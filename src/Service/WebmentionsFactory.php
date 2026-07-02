<?php

declare(strict_types=1);

namespace Asgrim\Service;

use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/** @codeCoverageIgnore */
final class WebmentionsFactory
{
    public function __invoke(ContainerInterface $container): Webmentions
    {
        /** @var array{webmention: array{token: string, domain: string}} $config */
        $config = $container->get('config');

        return new Webmentions(
            __DIR__ . '/../../data/cache/webmentions.json',
            $config['webmention']['token'],
            $config['webmention']['domain'],
            new Client(['timeout' => 5, 'connect_timeout' => 5]),
            $container->get(LoggerInterface::class),
        );
    }
}
