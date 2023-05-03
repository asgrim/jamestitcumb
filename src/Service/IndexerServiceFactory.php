<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Psr\Container\ContainerInterface;

/** @codeCoverageIgnore */
class IndexerServiceFactory
{
    public function __invoke(ContainerInterface $container): IndexerService
    {
        return new IndexerService(__DIR__ . '/../../data/posts/');
    }
}
