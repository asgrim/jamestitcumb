<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;

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
