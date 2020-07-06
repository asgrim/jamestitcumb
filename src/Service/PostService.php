<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Service\Exception\PostNotFound;
use Asgrim\Value\Post;

use function array_filter;
use function array_key_exists;
use function array_slice;
use function in_array;
use function sprintf;

class PostService
{
    private IndexerService $indexerService;

    public function __construct(IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

    /**
     * Fetch a number of recent posts (rendered).
     *
     * @return Post[]|array<string, Post>
     */
    public function fetchRecentPosts(int $howMany = 5): array
    {
        return array_slice($this->indexerService->getAllPostsFromCache(), 0, $howMany);
    }

    /**
     * Fetch a specific post by the slug (rendered).
     *
     * @throws PostNotFound
     */
    public function fetchPostBySlug(string $slug): Post
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        if (array_key_exists($slug, $posts)) {
            return $posts[$slug];
        }

        throw new Exception\PostNotFound(sprintf("Post '%s' not found.", $slug));
    }

    /**
     * Fetch all posts matching a specified tag
     *
     * @return Post[]|array<string, Post>
     */
    public function fetchPostsByTag(string $tag): array
    {
        return array_filter(
            $this->indexerService->getAllPostsFromCache(),
            static function (Post $post) use ($tag) {
                return in_array($tag, $post->tags(), true);
            }
        );
    }
}
