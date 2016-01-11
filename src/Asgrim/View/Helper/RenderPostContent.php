<?php

namespace Asgrim\View\Helper;

use Asgrim\Service\IndexerService;
use Zend\Form\View\Helper\AbstractHelper;
use Michelf\MarkdownExtra as Markdown;

class RenderPostContent extends AbstractHelper
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    /**
     * @param IndexerService $indexerService
     */
    public function __construct(IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

    public function __invoke($slug)
    {
        $text = $this->indexerService->getPostContentBySlug($slug);

        // Get rid of the metadata
        $text = substr($text, strpos($text, '---')+3);
        $text = substr($text, strpos($text, '---')+3);

        return Markdown::defaultTransform(trim($text));
    }
}
