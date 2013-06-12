<?php

namespace Asgrim\Action;

use Asgrim\Service\BlogService;
use Asgrim\Service\WordpressBlogRepository;

class BlogAction extends AbstractAction
{
	protected $blogService;

	public function getBlogService()
	{
		if (!$this->blogService)
		{
			$db = $this->getApplication()->getConfig('database');
			$pdoConnection = new \PDO($db['dsn'], $db['username'], $db['password']);
			$blogRepository = new WordpressBlogRepository($pdoConnection);
			$this->blogService = new BlogService($blogRepository);
		}

		return $this->blogService;
	}

	public function dispatch($request)
	{
		if ($request['slug'] == '')
		{
			$content = $this->getBlogService()->fetchLast(5);
		}
		else
		{
			$content = $this->getBlogService()->fetchBySlug($request['slug']);
		}

		return [
			'template' => 'blog',
			'variables' => ['content' => $content],
		];
	}
}
