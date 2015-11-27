<?php

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Client as EsClient;

/**
 * @covers \Asgrim\Service\SearchWrapper
 */
class SearchWrapperTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchWrapsElasticsearchReturnsEmptyArrayWithNoResults()
    {
        $esClient = $this->getMockBuilder(EsClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $esClient->expects($this->once())
            ->method('search')
            ->will($this->returnValue([
                'hits' => [
                    'total' => 0,
                ],
            ]));

        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($esClient, $indexer);
        $this->assertSame([], $wrapper->search('foo'));
    }

    public function testSearchWrapsElasticsearchReturnsSimplifiedArray()
    {
        $esClient = $this->getMockBuilder(EsClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $esClient->expects($this->once())
            ->method('search')
            ->will($this->returnValue([
                'hits' => [
                    'total' => 1,
                    'max_score' => 1,
                    'hits' => [
                        [
                            '_score' => 0.123,
                            '_id' => 'a-post-slug',
                        ]
                    ],
                ],
            ]));

        $indexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $wrapper = new SearchWrapper($esClient, $indexer);
        $this->assertSame([
            [
                'scorePercent' => 12.3,
                'slug' => 'a-post-slug',
            ]
        ], $wrapper->search('foo'));
    }
}
