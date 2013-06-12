<?php

namespace Asgrim\Service;

class BlogService
{
	protected $blogRepository;

	public function __construct(BlogRepositoryInterface $blogRepository)
	{
		$this->blogRepository = $blogRepository;
	}

	public function fetchBySlug($slug)
	{
		return $this->blogRepository->fetchBySlug($slug);
	}

	public function fetchLast($howeverMany = 5)
	{
		$howeverMany = (int)$howeverMany;

		if ($howeverMany <= 0 || $howeverMany > 20)
		{
			$howeverMany = 5;
		}

		return $this->blogRepository->fetchLast($howeverMany);
	}
}
