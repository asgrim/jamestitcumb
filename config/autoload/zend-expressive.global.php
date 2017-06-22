<?php
declare(strict_types=1);

return [
    'debug' => false,
    \Zend\ConfigAggregator\ConfigAggregator::ENABLE_CACHE => false,
    'zend-expressive' => [
        'error_handler' => [
            'template_404'   => 'error/404',
            'template_error' => 'error/error',
        ],
    ],
];
