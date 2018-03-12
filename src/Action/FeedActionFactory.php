<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;
use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class FeedActionFactory
{
    public function __invoke(ContainerInterface $container) : FeedAction
    {
        return new FeedAction(
            $container->get(FeedService::class),
            $container->get(PostService::class)
        );
    }
}
