<?php

namespace Asgrim;

use Silex\Application as SilexApplication;
use Herrera\Template\TemplateServiceProvider;
use Michelf\MarkdownExtra as Markdown;
use Symfony\Component\HttpFoundation\Request;

class Application extends SilexApplication
{
	protected $posts;

	public function __construct()
	{
		parent::__construct();

		$this['debug'] = true;

		$this->register(new TemplateServiceProvider(), array(
			'template.dir' => __DIR__ . '/../../views',
		));

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
		//$this->get('/books', array($this, 'booksAction'));
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
			$posts = array($slug => $this->fetchPostBySlug($slug));
			$posts[$slug]['active'] = true;
		}
		else
		{
			$posts = $this->fetchRecentPosts();
		}

		return $this['template.engine']->render('posts.php', array('posts' => $posts), true);
	}

	public function talksAction()
	{
		return $this['template.engine']->render('talks.php', array(), true);
	}

	public function booksAction()
	{
		return $this['template.engine']->render('books.php', array(), true);
	}

	public function getPosts()
	{
		if(!isset($this->posts))
		{
			$posts = require_once(__DIR__ . '/../../posts/posts.php');
		}

		return $posts;
	}

	public function renderPost($file)
	{
		$fullPath = __DIR__ . '/../../posts/' . $file;

		if (!file_exists($fullPath))
		{
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Markdown file called {$file} was missing");
		}

		$text = file_get_contents($fullPath);

		return Markdown::defaultTransform($text);
	}

	public function fetchRecentPosts()
	{
		$posts = $this->getPosts();

		$recentPosts = array_slice($posts, -5);

		foreach ($recentPosts as &$post)
		{
			$post['content'] = $this->renderPost($post['file']);
			$post['active'] = false;
		}

		return array_reverse($recentPosts);
	}

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
			throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Post with slug {$slug} not found.");
		}
	}
}
