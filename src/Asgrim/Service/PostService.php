<?php

namespace Asgrim\Service;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Michelf\MarkdownExtra as Markdown;

class PostService
{
    /**
     * @var string
     */
    private $postDirectory;

    /**
     * @var array
     */
    private $posts;

    /**
     * @param string $postDirectory
     */
    public function __construct($postDirectory)
    {
        $this->postDirectory = $postDirectory;
    }

    /**
     * Fetch the posts from the cache
     *
     * @return array
     */
    private function getPosts()
    {
        if(!isset($this->posts))
        {
            $this->posts = require_once($this->postDirectory . '/postsCache.php');
        }

        return $this->posts;
    }

    /**
     * Render the markdown (stripping metadata) of a post
     *
     * @param string $file Name of the file to render
     * @return string
     */
    private function renderPost($file)
    {
        $fullPath = $this->postDirectory . $file;

        if (!file_exists($fullPath))
        {
            throw new NotFoundHttpException("Markdown file called {$file} was missing");
        }

        $text = file_get_contents($fullPath);

        // Get rid of the metadata
        $text = substr($text, strpos($text, '---')+3);
        $text = substr($text, strpos($text, '---')+3);

        return Markdown::defaultTransform(trim($text));
    }

    /**
     * Fetch a number of recent posts (rendered)
     *
     * @param int $howMany
     * @return array
     */
    public function fetchRecentPosts($howMany = 5)
    {
        $posts = $this->getPosts();

        $recentPosts = array_slice($posts, -$howMany);

        foreach ($recentPosts as &$post)
        {
            $post['content'] = $this->renderPost($post['file']);
            $post['active'] = false;
        }

        return array_reverse($recentPosts);
    }

    /**
     * Fetch a specific post by the slug (rendered)
     *
     * @param string $slug
     * @return mixed
     */
    public function fetchPostBySlug($slug)
    {
        $posts = $this->getPosts();

        if (isset($posts[$slug]))
        {
            $posts[$slug]['content'] = $this->renderPost($posts[$slug]['file']);
            $posts[$slug]['active'] = false;
            return $posts[$slug];
        }
        else
        {
            throw new NotFoundHttpException("Post with slug {$slug} not found.");
        }
    }
}

