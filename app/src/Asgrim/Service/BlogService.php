<?php

namespace Asgrim\Service;

use Michelf\Markdown;
use Symfony\Component\Yaml\Yaml;

class BlogService
{
	protected $slugIndex;
	protected $markdownParser;

	public function __construct($postIndexFilename)
	{
		$fileContents = file_get_contents($postIndexFilename);
		$this->slugIndex = Yaml::parse($fileContents);
		$this->markdownParser = new Markdown();
	}

	public function fetchBySlug($slug)
	{
		$text = file_get_contents('app/posts/' . $this->slugIndex[$slug]);

		$text = str_replace('@[', '<a href="/blog/' . $slug . '">', $text);
		$text = str_replace(']@', '</a>', $text);

		return $this->markdownParser->defaultTransform($text);
	}

	public function fetchLast($howeverMany)
	{
		$howeverMany = (int)$howeverMany;

		if ($howeverMany <= 0 || $howeverMany > 20)
		{
			$howeverMany = 5;
		}

		$items = array_slice($this->slugIndex, -$howeverMany);

		$text = '';

		foreach ($items as $slug => $file)
		{
			$text .= $this->fetchBySlug($slug);
		}

		return $text;
	}
}