<?php

namespace Asgrim;

use Silex\Application as SilexApplication;
use Herrera\Template\TemplateServiceProvider;

class Application extends SilexApplication
{
	public function __construct()
	{
		parent::__construct();

		$this['debug'] = true;

		$this->register(new TemplateServiceProvider(), array(
			'template.dir' => __DIR__ . '/../../views',
		));

		$this->get('/', array($this, 'aboutAction'));
		$this->get('/posts', array($this, 'postsAction'));
		$this->get('/talks', array($this, 'talksAction'));
		$this->get('/books', array($this, 'booksAction'));
	}

	public function aboutAction()
	{
		return $this['template.engine']->render('about.php', array(), true);
	}

	public function postsAction()
	{
		return $this['template.engine']->render('posts.php', array(), true);
	}

	public function talksAction()
	{
		return $this['template.engine']->render('talks.php', array(), true);
	}

	public function booksAction()
	{
		return $this['template.engine']->render('books.php', array(), true);
	}
}
