<?php

declare(strict_types=1);

namespace Asgrim\Db;

use PDO;
use Psr\Container\ContainerInterface;

/** @codeCoverageIgnore */
final class PdoConnectionFactory
{
    public function __invoke(ContainerInterface $container): PDO
    {
        /** @var array{database: array{url: string}} $config */
        $config = $container->get('config');

        $dsn = DatabaseUrl::toPdoDsn($config['database']['url']);

        return new PDO($dsn['dsn'], $dsn['user'], $dsn['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
