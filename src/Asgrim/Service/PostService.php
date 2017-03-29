<?php
declare(strict_types=1);

namespace Asgrim\Service;

class PostService
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    /**
     * @param IndexerService $indexerService
     */
    public function __construct(IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

    /**
     * Fetch a number of recent posts (rendered).
     *
     * @param int $howMany
     * @return array
     */
    public function fetchRecentPosts(int $howMany = 5) : array
    {
        return array_slice($this->indexerService->getAllPostsFromCache(), 0, $howMany);
    }

    /**
     * Fetch a specific post by the slug (rendered).
     *
     * @param string $slug
     * @return mixed[]
     * @throws \Asgrim\Service\Exception\PostNotFound
     */
    public function fetchPostBySlug(string $slug) : array
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        if (array_key_exists($slug, $posts)) {
            return $posts[$slug];
        }

        throw new Exception\PostNotFound("Post '{$slug}' not found.");
    }

    /**
     * Fetch all posts matching a specified tag
     *
     * @param string $tag
     * @return array
     */
    public function fetchPostsByTag(string $tag) : array
    {
        return array_filter(
            $this->indexerService->getAllPostsFromCache(),
            function ($post) use ($tag) {
                return in_array($tag, $post['tags'], true);
            }
        );
    }
}
