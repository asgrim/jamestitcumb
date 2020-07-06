<?php
declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;

if (!getenv('HEROKU')) {
    return [];
}

$debug = (bool) getenv('DEBUG');

$config = [
    'debug' => $debug,
    ConfigAggregator::ENABLE_CACHE => true,
    'elasticsearch' => [
        'hosts' => [
            getenv('BONSAI_URL') . ':443',
        ],
    ],
];

if ($debug) {
    $config['templates']['map']['error/error'] = 'templates/error/debug.phtml';
}

return $config;
