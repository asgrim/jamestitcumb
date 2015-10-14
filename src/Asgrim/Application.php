<?php

namespace Asgrim;

use Asgrim\Service\PostService;
use Asgrim\Service\TalkService;
use Asgrim\Service\IndexerService;
use Silex\Application as SilexApplication;
use Herrera\Template\TemplateServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends SilexApplication
{
    public function __construct()
    {
        parent::__construct();

        $this['debug'] = true;

        $this->register(new TemplateServiceProvider(), array(
            'template.dir' => __DIR__ . '/../../views',
        ));

        $this['post_service'] = $this->share(function () {
            return new PostService(new IndexerService(__DIR__ . '/../../data/posts/'));
        });

        $this['talk_service'] = $this->share(function () {
            return new TalkService(__DIR__ . '/../../data/talks.php');
        });

        $this->error(function (\Exception $e, $code) {
            if ($code == 404)
            {
                return $this['template.engine']->render('404.php', array(), true);
            }
            else
            {
                if ($this['debug'])
                {
                    $vars = array('exception' => $e);
                }
                else
                {
                    $vars = array();
                }
                return $this['template.engine']->render('error.php', $vars, true);
            }
        });

        $this->get('/', array($this, 'aboutAction'));
        $this->get('/posts', array($this, 'postsAction'));
        $this->get('/posts/{slug}', array($this, 'postsAction'));
        $this->get('/talks', array($this, 'talksAction'));
        $this->get('/feed', array($this, 'feedAction'));
        $this->get('/feed/{format}', array($this, 'feedAction'));
    }

    public function feedAction(Request $request)
    {
        $baseUrl = 'http://www.jamestitcumb.com/';

        $outputFormat = $request->get('format', 'rss');

        if (!in_array($outputFormat, array('rss', 'rdf', 'atom')))
        {
            throw new \Exception('Invalid output format.');
        }

        $feed = new \Zend\Feed\Writer\Feed();
        $feed->setTitle('James Titcumb\'s blog');
        $feed->setLink($baseUrl);
        $feed->setDescription('This is James Titcumb\'s personal PHP-related blog posts.');
        $feed->setFeedLink($baseUrl . 'feed/atom', 'atom');
        $feed->addAuthor(array(
            'name' => 'James Titcumb',
            'uri' => $baseUrl,
        ));
        $feed->setDateModified(time());

        $posts = $this['post_service']->fetchRecentPosts(10);

        foreach ($posts as $slug => $post)
        {
            $entry = $feed->createEntry();
            $entry->setTitle($post['title']);
            $entry->setLink($baseUrl . 'posts/' . $slug);
            $entry->addAuthor(array(
                'name'  => 'James Titcumb',
                'uri'   => $baseUrl,
            ));
            $entry->setDateModified(new \DateTime($post['date']));
            $entry->setDateCreated(new \DateTime($post['date']));
            $entry->setDescription($post['title']);

            $content = str_replace(' allowfullscreen>', ' allowfullscreen="allowfullscreen">', $post['content']);

            $entry->setContent($content);

            $feed->addEntry($entry);
        }

        return $feed->export($outputFormat);
    }

    public function aboutAction()
    {
        return $this['template.engine']->render('about.php', array(), true);
    }

    public function postsAction(Request $request)
    {
        $slug = $request->get('slug');

        if (!is_null($slug))
        {
            $posts = array($slug => $this['post_service']->fetchPostBySlug($slug));
            $posts[$slug]['active'] = true;
        }
        else
        {
            $posts = $this['post_service']->fetchRecentPosts();
        }

        return $this['template.engine']->render('posts.php', array('posts' => $posts), true);
    }

    public function talksAction()
    {
        return $this['template.engine']->render('talks.php', [
            'upcoming' => $this['talk_service']->getUpcomingTalks(),
            'past' => $this['talk_service']->getPastTalks(),
        ], true);
    }
}
