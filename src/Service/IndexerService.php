<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Service\Exception\PostNotFound;
use Asgrim\Value\Post;
use DateTimeImmutable;
use DateTimeZone;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser as YamlParser;
use Webmozart\Assert\Assert;

use function array_key_exists;
use function assert;
use function basename;
use function count;
use function explode;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function sprintf;
use function sscanf;
use function str_replace;
use function strpos;
use function substr;
use function trim;
use function uasort;
use function var_export;

use const LOCK_EX;

class IndexerService
{
    private string $cacheFileName;

    private YamlParser $yamlParser;

    /** @var Post[]|array<string, Post>|null */
    private array|null $posts = null;

    public function __construct(private string $postFolder)
    {
        $this->cacheFileName = $postFolder . '/postsCache.php';
        $this->yamlParser    = new YamlParser();
    }

    /**
     * Create the posts cache index.
     *
     * Returns the number of posts created in the index.
     */
    public function createIndex(): int
    {
        $files = $this->buildFileListFromDirectory($this->postFolder);

        // Build cache in array
        $postIndex = [];
        foreach ($files as $file) {
            $metadata = $this->getPostMetadata($file);
            if ($metadata === null) {
                continue;
            }

            $postIndex[$metadata->slug()] = $metadata;
        }

        // Sort it by date
        $postIndex = $this->sortPostsByDate($postIndex);

        // Write to disk
        $cacheContent = var_export($postIndex, true);
        file_put_contents($this->cacheFileName, "<?php\nreturn " . $cacheContent . ";\n", LOCK_EX);

        return count($postIndex);
    }

    /**
     * Fetch the posts from the cache.
     *
     * @return Post[]|array<string, Post>
     */
    public function getAllPostsFromCache(): array
    {
        if (! isset($this->posts)) {
            /** @psalm-suppress UnresolvableInclude */
            $this->posts = require $this->cacheFileName;
        }

        return $this->posts;
    }

    /**
     * Get the raw content of a post (including metadata) by the slug.
     *
     * @throws PostNotFound
     */
    public function getPostContentBySlug(string $slug): string
    {
        $posts = $this->getAllPostsFromCache();

        if (! isset($posts[$slug])) {
            throw new Exception\PostNotFound(sprintf('No post was indexed with the slug: %s', $slug));
        }

        $fullPath = $this->postFolder . $posts[$slug]->file();

        if (! file_exists($fullPath)) {
            throw new Exception\PostNotFound(sprintf('Markdown file missing for slug: %s', $slug));
        }

        $postContent = file_get_contents($fullPath);

        Assert::string($postContent);

        return $postContent;
    }

    /**
     * Get the post content with the metadata stripped out
     *
     * @throws PostNotFound
     */
    public function getPostContentWithoutMetadata(string $slug): string
    {
        $text = $this->getPostContentBySlug($slug);

        // Get rid of the metadata
        $text = substr($text, (int) (strpos($text, '---')) + 3);
        $text = substr($text, (int) (strpos($text, '---')) + 3);

        return trim($text);
    }

    /**
     * Sort a list of posts by date.
     *
     * @param array<Post> $postIndex
     *
     * @return array<Post>
     */
    private function sortPostsByDate(array $postIndex): array
    {
        uasort($postIndex, static function (Post $a, Post $b) {
            return $a->date() > $b->date() ? -1 : 1;
        });

        return $postIndex;
    }

    /**
     * Build a flat file list of .md files from a directory.
     *
     * @return string[]
     */
    private function buildFileListFromDirectory(string $directory): array
    {
        $files = [];

        $iterator = new RecursiveDirectoryIterator($directory);

        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            assert($file instanceof SplFileInfo);
            if (! $file->isFile() || $file->getExtension() !== 'md') {
                continue;
            }

            $files[] = str_replace($this->postFolder, '', $file->getPathname());
        }

        return $files;
    }

    /**
     * Read a filename, extract the header and return the metadata as array.
     *
     * Returns null if there's no metadata or is a "draft" post.
     *
     * @throws ParseException
     */
    private function getPostMetadata(string $filename): Post|null
    {
        $contents = file_get_contents($this->postFolder . '/' . $filename);

        Assert::string($contents);

        $parts = explode('---', $contents);

        // No metadata
        if (count($parts) < 3) {
            return null;
        }

        $metadata = $parts[1];

        $parsed = $this->yamlParser->parse($metadata);

        // Don't index drafts
        if (! empty($parsed['draft'])) {
            return null;
        }

        if (! array_key_exists('tags', $parsed)) {
            $parsed['tags'] = [];
        }

        $fileparts = sscanf(basename($filename), '%d-%d-%d-%s');

        $date = DateTimeImmutable::createFromFormat(
            'Y-m-d',
            sprintf('%04d-%02d-%02d', $fileparts[0], $fileparts[1], $fileparts[2]),
            new DateTimeZone('UTC'),
        );

        Assert::notFalse($date);
        Assert::string($fileparts[3]);

        return Post::create(
            $parsed['title'],
            $parsed['tags'],
            $date,
            str_replace('.md', '', $fileparts[3]),
            $filename,
        );
    }
}
