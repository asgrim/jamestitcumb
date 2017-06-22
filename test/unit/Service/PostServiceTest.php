<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\PostService;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\Service\PostService
 */
final class PostServiceTest extends TestCase
{
    private static $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testFetchPostBySlug()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $post = $postService->fetchPostBySlug('test-post');

        self::assertSame('Test post from 2014', $post['title']);
        self::assertSame('2014-01-01', $post['date']);
        self::assertSame('test-post', $post['slug']);
    }

    public function testExceptionThrownWhenSlugNotFound()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Post \'this-slug-should-not-exist\' not found');
        $postService->fetchPostBySlug('this-slug-should-not-exist');
    }

    public function testFetchRecentPostsReturnsPosts()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $posts = $postService->fetchRecentPosts();

        self::assertCount(3, $posts);
    }

    public function testFetchRecentPostsReturnsTwoPostsWhenRequested()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $posts = $postService->fetchRecentPosts(2);

        self::assertCount(2, $posts);
    }

    public function tearDown()
    {
        $cache = self::$postsFolder . '/postsCache.php';
        if (file_exists($cache)) {
            unlink($cache);
        }
    }
}
