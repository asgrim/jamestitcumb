<?php

declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Service\IndexerService;
use Laminas\View\Helper\AbstractHelper;
use Michelf\MarkdownExtra as Markdown;

class RenderPostContent extends AbstractHelper
{
    public function __construct(private IndexerService $indexerService)
    {
    }

    public function __invoke(string $slug): string
    {
        return Markdown::defaultTransform($this->indexerService->getPostContentWithoutMetadata($slug));
    }
}
