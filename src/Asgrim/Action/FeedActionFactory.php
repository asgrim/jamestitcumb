<?php

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Asgrim\Service\FeedService;
use Asgrim\Service\PostService;

class FeedActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new FeedAction(
            $container->get(FeedService::class),
            $container->get(PostService::class)
        );
    }
}
