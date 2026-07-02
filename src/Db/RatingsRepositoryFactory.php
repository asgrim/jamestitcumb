<?php

declare(strict_types=1);

namespace Asgrim\Db;

use PDO;
use Psr\Container\ContainerInterface;

/** @codeCoverageIgnore */
final class RatingsRepositoryFactory
{
    public function __invoke(ContainerInterface $container): RatingsRepository
    {
        return new RatingsRepository($container->get(PDO::class));
    }
}
