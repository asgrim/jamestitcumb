<?php

namespace Asgrim\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

class IndexCommand extends Command
{
	protected $postFolder;

	protected $parser;

	public function __construct()
	{
		$this->postFolder = realpath(__DIR__ . '/../../../posts/');

		parent::__construct();
	}

	public function setParser(Parser $parser)
	{
		$this->parser = $parser;
	}

	public function getParser()
	{
		if (!isset($this->parser))
		{
			$this->parser = new Parser();
		}

		return $this->parser;
	}

	protected function configure()
	{
		$this->setName('index-posts')
			->setDescription('Indexes the blog posts to create a cached list of them');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$files = $this->buildFileListFromDirectory($this->postFolder);

		$postIndex = array();
		foreach ($files as $file)
		{
			$metadata = $this->getPostMetadata($file);

			if(!is_null($metadata))
			{
				$postIndex[$metadata['slug']] = $metadata;
			}
		}

		usort($postIndex, function ($a, $b) {
			$aa = (int)str_replace('-', '', $a['date']);
			$bb = (int)str_replace('-', '', $b['date']);
			if ($aa > $bb) return 1;
			else if ($bb > $aa) return -1;
			else return 0;
		});

		$cacheContent = var_export($postIndex, true);

		file_put_contents($this->postFolder . '/postsCache.php', "<?php\nreturn " . $cacheContent . ";\n");
	}

	public function buildFileListFromDirectory($directory)
	{
		$files = array();

		$iterator = new \RecursiveDirectoryIterator($directory);

		foreach (new \RecursiveIteratorIterator($iterator) as $file)
		{
			/** @var $file \SplFileInfo */
			if (!$file->isFile() || $file->getExtension() != 'md')
			{
				continue;
			}

			$files[] = str_replace($this->postFolder, '', $file->getPathname());
		}

		return $files;
	}

	public function getPostMetadata($filename)
	{
		$contents = file_get_contents($this->postFolder . '/' . $filename);

		$parts = explode('---', $contents);

		// No metadata
		if (count($parts) < 3)
		{
			return;
		}

		$metadata = $parts[1];

		$parsed = $this->getParser()->parse($metadata);

		// Don't index drafts
		if (isset($parsed['draft']) && $parsed['draft'])
		{
			return;
		}

		$fileparts = sscanf(basename($filename), '%d-%d-%d-%s');

		$parsed['date'] = sprintf('%04d-%02d-%02d', $fileparts[0], $fileparts[1], $fileparts[2]);
		$parsed['slug'] = str_replace('.md', '', $fileparts[3]);
		$parsed['file'] = substr($filename, 1);

		return $parsed;
	}
}
