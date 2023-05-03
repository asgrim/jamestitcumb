<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\IndexerService;
use Asgrim\Value\Post;
use DateTimeImmutable;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

use function file_exists;
use function strlen;
use function unlink;

/** @covers \Asgrim\Service\IndexerService */
final class IndexerServiceTest extends TestCase
{
    private static string $postsFolder = __DIR__ . '/../../fixture/posts/';

    public function testIndexerCreatesUsableCache(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        self::assertSame(3, $indexer->createIndex());
    }

    public function testIndexerFetchesCache(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();
        $posts = $indexer->getAllPostsFromCache();

        self::assertCount(3, $posts);
    }

    public function testIndexerCanFetchSpecificPost(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $post = $indexer->getPostContentBySlug('test-post');
        self::assertIsString($post);
        self::assertGreaterThan(0, strlen($post));
    }

    public function testIndexerFailsWhenSlugDoesNotExist(): void
    {
        $indexer = new IndexerService(self::$postsFolder);
        $indexer->createIndex();

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('No post was indexed with the slug');

        /** @noinspection UnusedFunctionResultInspection */
        $indexer->getPostContentBySlug('this-slug-should-not-exist');
    }

    /** @throws ReflectionException */
    public function testIndexerFailsWhenSlugExistsButFileDoesNot(): void
    {
        $indexer = new IndexerService(self::$postsFolder);

        $postsProperty = new ReflectionProperty($indexer, 'posts');
        $postsProperty->setAccessible(true);
        $postsProperty->setValue($indexer, [
            'test-post-slug' => Post::create(
                'Test post title',
                [],
                DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-01'),
                'test-post-slug',
                'foo/bar/baz/should/not/exist.md',
            ),
        ]);

        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Markdown file missing for slug');

        /** @noinspection UnusedFunctionResultInspection */
        $indexer->getPostContentBySlug('test-post-slug');
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
