<?php

namespace Asgrim\Service;

use Michelf\MarkdownExtra as Markdown;

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
     * Render the markdown (stripping metadata) of a post.
     *
     * @param string $slug
     * @return string
     */
    private function renderPost($slug)
    {
        $text = $this->indexerService->getPostContentBySlug($slug);

        // Get rid of the metadata
        $text = substr($text, strpos($text, '---')+3);
        $text = substr($text, strpos($text, '---')+3);

        return Markdown::defaultTransform(trim($text));
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
            $post['content'] = $this->renderPost($post['slug']);
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
            $posts[$slug]['content'] = $this->renderPost($slug);
            $posts[$slug]['active'] = false;
            return $posts[$slug];
        } else {
            throw new \OutOfBoundsException("Post with slug {$slug} not found.");
        }
    }
}
