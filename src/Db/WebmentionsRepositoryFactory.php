<?php

declare(strict_types=1);

namespace Asgrim\Db;

use PDO;
use Psr\Container\ContainerInterface;

/** @codeCoverageIgnore */
final class WebmentionsRepositoryFactory
{
    public function __invoke(ContainerInterface $container): WebmentionsRepository
    {
        return new WebmentionsRepository($container->get(PDO::class));
    }
}
