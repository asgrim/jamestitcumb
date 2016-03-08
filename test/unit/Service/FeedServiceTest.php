<?php

namespace AsgrimTest\Service;

use Asgrim\Service\FeedService;
use Asgrim\Service\IndexerService;
use Asgrim\View\Helper\RenderPostContent;
use Zend\Feed\Writer\Feed;

/**
 * @covers \Asgrim\Service\FeedService
 */
class FeedServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testFeedServiceCreatesFeedEvenWithEmptyPostsArray()
    {
        $feedService = new FeedService(new RenderPostContent(new IndexerService('')));
        $feed = $feedService->createFeed([]);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertSame(0, $feed->count());
    }

    public function testFeedServiceWithPosts()
    {
        /** @var RenderPostContent|\PHPUnit_Framework_MockObject_MockObject $postRenderer */
        $postRenderer = $this->getMockBuilder(RenderPostContent::class)
            ->disableOriginalConstructor()
            ->setMethods(['__invoke'])
            ->getMock();

        $postRenderer->expects($this->exactly(2))
            ->method('__invoke')
            ->willReturn('foo');

        $feedService = new FeedService($postRenderer);
        $feed = $feedService->createFeed([
            [
                'title' => 'Post title 1',
                'date' => '2015-01-01',
                'content' => 'Some post content',
                'slug' => 'post-slug-1',
            ],
            [
                'title' => 'Post title 2',
                'date' => '2015-01-01',
                'content' => 'Some more post content',
                'slug' => 'post-slug-2',
            ],
        ]);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertSame(2, $feed->count());
    }
}
