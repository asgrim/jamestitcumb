<?php

namespace Asgrim\Service;

use Interop\Container\ContainerInterface;

class IndexerServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new IndexerService(__DIR__ . '/../../../data/posts/');
    }
}
