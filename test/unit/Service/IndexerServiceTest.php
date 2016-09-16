<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use OutOfBoundsException;

/**
 * @covers \Asgrim\Service\IndexerService
 */
final class IndexerServiceTest extends \PHPUnit_Framework_TestCase
{
    private static $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testIndexerCreatesUsableCache()
    {
        $indexer = new IndexerService(self::$postsFolder);
        self::assertSame(3, $indexer->createIndex());
    }

    public function testIndexerFetchesCache()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();
        $posts = $indexer->getAllPostsFromCache();

        self::assertCount(3, $posts);
    }

    public function testIndexerCanFetchSpecificPost()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $post = $indexer->getPostContentBySlug('test-post');
        self::assertInternalType('string', $post);
        self::assertGreaterThan(0, strlen($post));
    }

    public function testIndexerFailsWhenSlugDoesNotExist()
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('No post was indexed with the slug');
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

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Markdown file missing for slug');
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
