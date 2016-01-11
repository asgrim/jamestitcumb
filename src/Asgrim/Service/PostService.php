<?php

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
    public function fetchRecentPosts($howMany = 5)
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        $recentPosts = array_slice($posts, -$howMany);

        foreach ($recentPosts as &$post) {
            $post['active'] = false;
        }

        return array_reverse($recentPosts);
    }

    /**
     * Fetch a specific post by the slug (rendered).
     *
     * @param string $slug
     * @return mixed
     */
    public function fetchPostBySlug($slug)
    {
        $posts = $this->indexerService->getAllPostsFromCache();

        if (isset($posts[$slug])) {
            $posts[$slug]['active'] = false;
            return $posts[$slug];
        } else {
            throw new Exception\PostNotFound("Post '{$slug}' not found.");
        }
    }
}
