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

        $this->register(new TemplateServiceProvider(), [
            'template.dir' => __DIR__ . '/../../views',
        ]);

        $this['post_service'] = $this->share(function () {
            return new PostService(new IndexerService(__DIR__ . '/../../data/posts/'));
        });

        $this['talk_service'] = $this->share(function () {
            return new TalkService(__DIR__ . '/../../data/talks.php');
        });

        $this->error(function (\Exception $e, $code) {
            if ($code == 404) {
                return $this['template.engine']->render('404.php', [], true);
            } else {
                if ($this['debug']) {
                    $vars = ['exception' => $e];
                } else {
                    $vars = [];
                }
                return $this['template.engine']->render('error.php', $vars, true);
            }
        });

        $this->get('/', [$this, 'aboutAction']);
        $this->get('/posts', [$this, 'postsAction']);
        $this->get('/posts/{slug}', [$this, 'postsAction']);
        $this->get('/talks', [$this, 'talksAction']);
        $this->get('/feed', [$this, 'feedAction']);
        $this->get('/feed/{format}', [$this, 'feedAction']);
    }

    public function feedAction(Request $request)
    {
        $outputFormat = $request->get('format', 'rss');

        if (!in_array($outputFormat, ['rss', 'rdf', 'atom'])) {
            throw new \Exception('Invalid output format.');
        }

        /** @var \Zend\Feed\Writer\Feed $feed */
        $feed = $this['feed_service']->createFeed(
            $this['post_service']->fetchRecentPosts(10)
        );

        return $feed->export($outputFormat);
    }

    public function aboutAction()
    {
        return $this['template.engine']->render('about.php', [], true);
    }

    public function postsAction(Request $request)
    {
        $slug = $request->get('slug');

        if (!is_null($slug)) {
            $posts = [$slug => $this['post_service']->fetchPostBySlug($slug)];
            $posts[$slug]['active'] = true;
        } else {
            $posts = $this['post_service']->fetchRecentPosts();
        }

        return $this['template.engine']->render('posts.php', ['posts' => $posts], true);
    }

    public function talksAction()
    {
        return $this['template.engine']->render('talks.php', [
            'upcoming' => $this['talk_service']->getUpcomingTalks(),
            'past' => $this['talk_service']->getPastTalks(),
        ], true);
    }
}
