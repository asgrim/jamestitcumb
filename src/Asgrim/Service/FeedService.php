<?php

namespace Asgrim\Service;

use DateTime;
use Zend\Feed\Writer\Feed;

class FeedService
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string[]
     */
    private $author;

    public function __construct()
    {
        $this->baseUrl = 'http://www.jamestitcumb.com/';
        $this->title = 'James Titcumb\'s blog';
        $this->description = 'This is James Titcumb\'s personal PHP-related blog posts.';
        $this->author = [
            'name' => 'James Titcumb',
            'url' => $this->baseUrl,
        ];
    }

    /**
     * Create a feed from an array of posts. The format of the posts should be
     * that returned by the PostService.
     *
     * @param array $posts
     * @return Feed
     */
    public function createFeed(array $posts)
    {
        $feed = new Feed();
        $feed->setTitle($this->title);
        $feed->setLink($this->baseUrl);
        $feed->setDescription($this->description);
        $feed->setFeedLink($this->baseUrl . 'feed/atom', 'atom');
        $feed->setDateModified(time());
        $feed->addAuthor($this->author);

        foreach ($posts as $slug => $post) {
            $entry = $feed->createEntry();
            $entry->setTitle($post['title']);
            $entry->setLink($this->baseUrl . 'posts/' . $slug);
            $entry->addAuthor($this->author);
            $entry->setDateModified(new DateTime($post['date']));
            $entry->setDateCreated(new DateTime($post['date']));
            $entry->setDescription($post['title']);

            $content = str_replace(' allowfullscreen>', ' allowfullscreen="allowfullscreen">', $post['content']);

            $entry->setContent($content);

            $feed->addEntry($entry);
        }

        return $feed;
    }
}

