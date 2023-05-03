<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Http\Discovery\Psr18Client;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/** @codeCoverageIgnore */
class RatingsFactory
{
    public function __invoke(ContainerInterface $container): Ratings
    {
        return new Ratings(
            __DIR__ . '/../../data/cache/ratings.json',
            $container->get(LoggerInterface::class),
            $container->get(TalkService::class),
            new Psr18Client(),
        );
    }
}
