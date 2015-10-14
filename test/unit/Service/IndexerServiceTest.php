<?php

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @covers \Asgrim\Service\IndexerService
 */
class IndexerServiceTest extends \PHPUnit_Framework_TestCase
{
    private static $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testIndexerCreatesUsableCache()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $this->assertSame(3, $indexer->createIndex());
    }

    public function testIndexerFetchesCache()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();
        $posts = $indexer->getAllPostsFromCache();

        $this->assertCount(3, $posts);
    }

    public function testIndexerCanFetchSpecificPost()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $post = $indexer->getPostContentBySlug('test-post');
        $this->assertInternalType('string', $post);
        $this->assertGreaterThan(0, strlen($post));
    }

    public function testIndexerFailsWhenSlugDoesNotExist()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $this->setExpectedException(NotFoundHttpException::class, 'No post was indexed with the slug');
        $indexer->getPostContentBySlug('this-slug-should-not-exist');
    }

    public function testIndexerFailsWhenSlugExistsButFileDoesNot()
    {
        $indexer = new IndexerService(self::$postsFolder);

        $postsProperty = new \ReflectionProperty($indexer, 'posts');
        $postsProperty->setAccessible(true);
        $postsProperty->setValue($indexer, [
            'test-post-slug' => [
                'title' => 'Test post title',
                'date' => '2015-01-01',
                'slug' => 'test-post-slug',
                'file' => 'foo/bar/baz/should/not/exist.md',
            ],
        ]);

        $this->setExpectedException(NotFoundHttpException::class, 'Markdown file missing for slug');
        $indexer->getPostContentBySlug('test-post-slug');
    }

    public function tearDown()
    {
        $cache = self::$postsFolder . '/postsCache.php';
        if (file_exists($cache)) {
            unlink($cache);
        }
    }
}
