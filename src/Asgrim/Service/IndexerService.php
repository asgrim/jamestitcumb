<?php

namespace Asgrim\Service;

use Symfony\Component\Yaml\Parser as YamlParser;

class IndexerService
{
    /**
     * @var string
     */
    private $postFolder;

    /**
     * @var string
     */
    private $cacheFileName;

    /**
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * @param string $postFolder
     * @param YamlParser $yamlParser
     */
    public function __construct($postFolder, YamlParser $yamlParser)
    {
        $this->postFolder = $postFolder;
        $this->cacheFileName = $postFolder . '/postsCache.php';
        $this->yamlParser = $yamlParser;
    }

    /**
     * Create the posts cache index.
     *
     * Returns the number of posts created in the index.
     *
     * @return int
     */
    public function createIndex()
    {
        $files = $this->buildFileListFromDirectory($this->postFolder);

        // Build cache in array
        $postIndex = [];
        foreach ($files as $file)
        {
            if($metadata = $this->getPostMetadata($file))
            {
                $postIndex[$metadata['slug']] = $metadata;
            }
        }

        // Sort it by date
        $postIndex = $this->sortPostsByDate($postIndex);

        // Write to disk
        $cacheContent = var_export($postIndex, true);
        file_put_contents($this->cacheFileName, "<?php\nreturn " . $cacheContent . ";\n");

        return count($postIndex);
    }

    /**
     * Sort a list of posts by date
     *
     * @param mixed[] $postIndex
     * @return mixed[]
     */
    private function sortPostsByDate($postIndex)
    {
        uasort($postIndex, function ($a, $b) {
            $aa = (int)str_replace('-', '', $a['date']);
            $bb = (int)str_replace('-', '', $b['date']);
            if ($aa > $bb) return 1;
            else if ($bb > $aa) return -1;
            else return 0;
        });

        return $postIndex;
    }

    /**
     * Build a flat file list of .md files from a directory
     *
     * @param string $directory
     * @return string[]
     */
    private function buildFileListFromDirectory($directory)
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

    /**
     * Read a filename, extract the header and return the metadata as array.
     *
     * Returns null if there's no metadata or is a "draft" post.
     *
     * @param string $filename
     * @return mixed[]|null
     */
    private function getPostMetadata($filename)
    {
        $contents = file_get_contents($this->postFolder . '/' . $filename);

        $parts = explode('---', $contents);

        // No metadata
        if (count($parts) < 3)
        {
            return null;
        }

        $metadata = $parts[1];

        $parsed = $this->yamlParser->parse($metadata);

        // Don't index drafts
        if (isset($parsed['draft']) && $parsed['draft'])
        {
            return null;
        }

        $fileparts = sscanf(basename($filename), '%d-%d-%d-%s');

        $parsed['date'] = sprintf('%04d-%02d-%02d', $fileparts[0], $fileparts[1], $fileparts[2]);
        $parsed['slug'] = str_replace('.md', '', $fileparts[3]);
        $parsed['file'] = substr($filename, 1);

        return $parsed;
    }
}
