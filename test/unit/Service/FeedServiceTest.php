<?php

namespace AsgrimTest\Service;

use Asgrim\Service\FeedService;
use Zend\Feed\Writer\Feed;

/**
 * @covers \Asgrim\Service\FeedService
 */
class FeedServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFeedServiceCreatesFeedEvenWithEmptyPostsArray()
    {
        $feedService = new FeedService();
        $feed = $feedService->createFeed([]);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertSame(0, $feed->count());
    }

    public function testFeedServiceWithPosts()
    {
        $feedService = new FeedService();
        $feed = $feedService->createFeed([
            [
                'title' => 'Post title 1',
                'date' => '2015-01-01',
                'content' => 'Some post content',
            ],
            [
                'title' => 'Post title 2',
                'date' => '2015-01-01',
                'content' => 'Some more post content',
            ],
        ]);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertSame(2, $feed->count());
    }
}
