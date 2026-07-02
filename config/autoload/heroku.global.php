<?php
declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

if (!getenv('HEROKU')) {
    return [];
}

$debug = (bool) getenv('DEBUG');

$databaseUrl = (string) getenv('DATABASE_URL');
if ($databaseUrl !== '') {
    $databaseUrl .= (str_contains($databaseUrl, '?') ? '&' : '?') . 'sslmode=require';
}

$config = [
    'debug' => $debug,
    ConfigAggregator::ENABLE_CACHE => true,
    'elasticsearch' => [
        'hosts' => [
            getenv('BONSAI_URL') . ':443',
        ],
    ],
    'webmention' => [
        'token' => (string) getenv('WEBMENTION_IO_TOKEN'),
    ],
    'database' => [
        'url' => $databaseUrl,
    ],
];

if ($debug) {
    $config['templates']['map']['error/error'] = 'templates/error/debug.phtml';
}

return $config;
