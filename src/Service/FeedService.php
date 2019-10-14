<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Value\Post;
use Asgrim\View\Helper\RenderPostContent;
use Zend\Feed\Writer\Exception\InvalidArgumentException;
use Zend\Feed\Writer\Feed;
use function str_replace;
use function time;

class FeedService
{
    /** @var string */
    private $baseUrl;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string[] */
    private $author;

    /** @var RenderPostContent */
    private $renderPostContent;

    public function __construct(RenderPostContent $renderPostContent)
    {
        $this->baseUrl           = 'https://www.jamestitcumb.com/';
        $this->title             = 'James Titcumb\'s blog';
        $this->description       = 'This is James Titcumb\'s personal PHP-related blog posts.';
        $this->author            = [
            'name' => 'James Titcumb',
            'url' => $this->baseUrl,
        ];
        $this->renderPostContent = $renderPostContent;
    }

    /**
     * Create a feed from an array of posts. The format of the posts should be
     * that returned by the PostService.
     *
     * @param Post[]|array<string, Post> $posts
     *
     * @throws InvalidArgumentException
     */
    public function createFeed(array $posts, string $titleSuffix = '', string $linkSuffix = '') : Feed
    {
        $feed = new Feed();
        $feed->setTitle($this->title . $titleSuffix);
        $feed->setLink($this->baseUrl . 'posts' . $linkSuffix);
        $feed->setDescription($this->description);
        $feed->setFeedLink($this->baseUrl . 'feed/atom', 'atom');
        $feed->setDateModified(time());
        $feed->addAuthor($this->author);

        foreach ($posts as $slug => $post) {
            $entry = $feed->createEntry();
            $entry->setTitle($post->title());
            $entry->setLink($this->baseUrl . 'posts/' . $slug);
            $entry->addAuthor($this->author);
            $entry->setDateModified($post->date());
            $entry->setDateCreated($post->date());
            $entry->setDescription($post->title());

            $content = str_replace(
                ' allowfullscreen>',
                ' allowfullscreen="allowfullscreen">',
                $this->renderPostContent->__invoke($post->slug())
            );

            $entry->setContent($content);

            $feed->addEntry($entry);
        }

        return $feed;
    }
}
