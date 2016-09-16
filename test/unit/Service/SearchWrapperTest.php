<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\ClientBuilder;

/**
 * @covers \Asgrim\Service\SearchWrapper
 */
final class SearchWrapperTest extends \PHPUnit_Framework_TestCase
{
    private static $esClient;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$esClient = ClientBuilder::create()->build();
    }

    private function getIndexedEsClient()
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
                ]
            ]);

        $wrapper = new SearchWrapper(self::$esClient, $indexer);
        $wrapper->indexAllPosts();

        sleep(1); // Could do with a better way of waiting for index to catch up
        return self::$esClient;
    }

    public function testIndexingAllPosts()
    {
        $this->getIndexedEsClient();
    }

    /**
     *
     */
    public function testSearchReturnsEmptyArrayWithNoResults()
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([], $wrapper->search('zibble'));
    }

    public function testSearchReturnsResultWhenSearchingContent()
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([
            [
                'scorePercent' => 100.0,
                'slug' => 'a-test-slug',
            ]
        ], $wrapper->search('wibble'));
    }

    public function testSearchReturnsResultWhenSearchingTitle()
    {
        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($this->getIndexedEsClient(), $indexer);
        self::assertSame([
            [
                'scorePercent' => 100.0,
                'slug' => 'a-test-slug',
            ]
        ], $wrapper->search('fibble'));
    }
}
