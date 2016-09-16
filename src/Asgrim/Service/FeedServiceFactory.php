<?php
declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\View\Helper\RenderPostContent;
use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class FeedServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $indexerService = $container->get(IndexerService::class);
        $renderPostContent = new RenderPostContent($indexerService);

        return new FeedService($renderPostContent);
    }
}
