<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\FeedService;
use Asgrim\Service\IndexerService;
use Asgrim\Value\Post;
use Asgrim\View\Helper\RenderPostContent;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

use function assert;

/** @covers \Asgrim\Service\FeedService */
final class FeedServiceTest extends TestCase
{
    public function testFeedServiceCreatesFeedEvenWithEmptyPostsArray(): void
    {
        self::assertSame(
            0,
            (new FeedService(new RenderPostContent(new IndexerService(''))))->createFeed([])->count(),
        );
    }

    public function testFeedServiceWithPosts(): void
    {
        $postRenderer = $this->createMock(RenderPostContent::class);
        assert($postRenderer instanceof RenderPostContent || $postRenderer instanceof MockObject);

        $postRenderer->expects(self::exactly(2))
            ->method('__invoke')
            ->willReturn('foo');

        $feed = (new FeedService($postRenderer))->createFeed([
            Post::create(
                'Post title 1',
                [],
                DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-01'),
                'post-slug-1',
                'no file',
            ),
            Post::create(
                'Post title 2',
                [],
                DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-01'),
                'post-slug-2',
                'no file',
            ),
        ]);

        self::assertSame(2, $feed->count());
    }
}
