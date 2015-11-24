<?php

namespace Asgrim\Service;

use Interop\Container\ContainerInterface;

class PostServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PostService($container->get(IndexerService::class));
    }
}
