<?php
declare(strict_types=1);

namespace Asgrim\Service;

use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class PostServiceFactory
{
    public function __invoke(ContainerInterface $container) : PostService
    {
        return new PostService($container->get(IndexerService::class));
    }
}
