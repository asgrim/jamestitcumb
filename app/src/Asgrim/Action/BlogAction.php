<?php

namespace Asgrim\Action;

use Asgrim\Service\BlogService;

class BlogAction extends AbstractAction
{
	protected $blogService;

	public function getBlogService()
	{
		if (!$this->blogService)
		{
			$this->blogService = new BlogService($this->getApplication()->getConfig('directories')['post-index']);
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