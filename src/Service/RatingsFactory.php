<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Db\RatingsRepository;
use Http\Discovery\Psr18Client;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/** @codeCoverageIgnore */
final class RatingsFactory
{
    public function __invoke(ContainerInterface $container): Ratings
    {
        return new Ratings(
            $container->get(RatingsRepository::class),
            $container->get(LoggerInterface::class),
            $container->get(TalkService::class),
            new Psr18Client(),
        );
    }
}
