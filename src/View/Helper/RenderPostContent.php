<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Service\IndexerService;
use Michelf\MarkdownExtra as Markdown;
use Zend\View\Helper\AbstractHelper;

class RenderPostContent extends AbstractHelper
{
    /** @var IndexerService */
    private $indexerService;

    public function __construct(IndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

    public function __invoke(string $slug) : string
    {
        return Markdown::defaultTransform($this->indexerService->getPostContentWithoutMetadata($slug));
    }
}
