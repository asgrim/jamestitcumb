<?php

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Service\PostService;
use \OutOfBoundsException;

/**
 * @covers \Asgrim\Service\PostService
 */
class PostServiceTest extends \PHPUnit_Framework_TestCase
{
    private static $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testFetchPostBySlug()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $post = $postService->fetchPostBySlug('test-post');

        $this->assertSame('Test post from 2014', $post['title']);
        $this->assertSame('2014-01-01', $post['date']);
        $this->assertSame('test-post', $post['slug']);
        $this->assertContains('<p>This is the content in <em>Markdown</em>.</p>', $post['content']);
    }

    public function testExceptionThrownWhenSlugNotFound()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);

        $this->setExpectedException(OutOfBoundsException::class, 'Post \'this-slug-should-not-exist\' not found');
        $postService->fetchPostBySlug('this-slug-should-not-exist');
    }

    public function testFetchRecentPostsReturnsPosts()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $posts = $postService->fetchRecentPosts();

        $this->assertCount(3, $posts);
    }

    public function testFetchRecentPostsReturnsTwoPostsWhenRequested()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $postService = new PostService($indexer);
        $posts = $postService->fetchRecentPosts(2);

        $this->assertCount(2, $posts);
    }

    public function tearDown()
    {
        $cache = self::$postsFolder . '/postsCache.php';
        if (file_exists($cache)) {
            unlink($cache);
        }
    }
}
