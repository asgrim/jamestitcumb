<?php
declare(strict_types=1);

if (!getenv('HEROKU')) {
    return [];
}

return [
    'debug' => false,
    \Zend\ConfigAggregator\ConfigAggregator::ENABLE_CACHE => true,
    'templates' => [
        'map' => [
            'error/error'   => 'templates/error/debug.phtml',
        ],
    ],
    'elasticsearch' => [
        'hosts' => [
            getenv('BONSAI_URL') . ':443',
        ],
    ],
];
