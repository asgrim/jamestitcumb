<?php

namespace Asgrim\Service;

interface BlogRepositoryInterface
{
	public function fetchBySlug($slug);

	public function fetchLast($howeverMany);
}
