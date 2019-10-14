<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;
use PHPUnit\Framework\TestCase;
use function sleep;

/**
 * @covers \Asgrim\Service\SearchWrapper
 */
final class SearchWrapperTest extends TestCase
{
    /** @var ElasticsearchClient */
    private static $esClient;

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();

        $config = require __DIR__ . '/../../../config/autoload/local.php';

        self::$esClient = ClientBuilder::create()
            ->setHosts($config['elasticsearch']['hosts'])
            ->build();
    }

    private function getIndexedEsClient() : ElasticsearchClient
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $indexer->expects(self::once())
            ->method('getPostContentWithoutMetadata')
            ->with('a-test-slug')
            ->willReturn('This is some post content with keyword wibble.');

        $indexer->expects(self::once())
            ->method('getAllPostsFromCache')
            ->with()
            ->willReturn([
                [
                    'slug' => 'a-test-slug',
                    'title' => 'post-title-fibble',
                ],
            ]);

        $wrapper = new SearchWrapper(self::$esClient, $indexer);
        $wrapper->indexAllPosts();

        sleep(1); // Could do with a better way of waiting for index to catch up

        return self::$esClient;
    }

    public function testIndexingAllPosts() : void
    {
        $this->getIndexedEsClient();
    }

    public function testSearchReturnsEmptyArrayWithNoResults() : void
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([], $wrapper->search('zibble'));
    }

    public function testSearchReturnsResultWhenSearchingContent() : void
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([
            [
                'scorePercent' => 100.0,
                'slug' => 'a-test-slug',
            ],
        ], $wrapper->search('wibble'));
    }

    public function testSearchReturnsResultWhenSearchingTitle() : void
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([
            [
                'scorePercent' => 100.0,
                'slug' => 'a-test-slug',
            ],
        ], $wrapper->search('fibble'));
    }
}
