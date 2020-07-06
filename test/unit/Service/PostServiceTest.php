<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\PostService;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

use function file_exists;
use function unlink;

/**
 * @covers \Asgrim\Service\PostService
 */
final class PostServiceTest extends TestCase
{
    private static string $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testFetchPostBySlug(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $post = (new PostService($indexer))->fetchPostBySlug('test-post');

        self::assertSame('Test post from 2014', $post->title());
        self::assertSame('2014-01-01', $post->date()->format('Y-m-d'));
        self::assertSame('test-post', $post->slug());
    }

    public function testExceptionThrownWhenSlugNotFound(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Post \'this-slug-should-not-exist\' not found');

        /** @noinspection UnusedFunctionResultInspection */
        $postService->fetchPostBySlug('this-slug-should-not-exist');
    }

    public function testFetchRecentPostsReturnsPosts(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $posts = (new PostService($indexer))->fetchRecentPosts();

        self::assertCount(3, $posts);
    }

    public function testFetchRecentPostsReturnsTwoPostsWhenRequested(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $posts = (new PostService($indexer))->fetchRecentPosts(2);

        self::assertCount(2, $posts);
    }

    public function tearDown(): void
    {
        $cache = self::$postsFolder . '/postsCache.php';
        if (! file_exists($cache)) {
            return;
        }

        unlink($cache);
    }
}
