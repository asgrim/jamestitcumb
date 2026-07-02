<?php

declare(strict_types=1);

use Asgrim\Db\DatabaseUrl;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';

$dsn = DatabaseUrl::toPdoDsn((string) ($config['database']['url'] ?? ''));

$pdo = new PDO($dsn['dsn'], $dsn['user'], $dsn['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'default',
        'default' => [
            'adapter' => 'pgsql',
            'connection' => $pdo,
            'name' => $dsn['name'],
        ],
    ],
];
