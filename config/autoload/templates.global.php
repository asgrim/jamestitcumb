<?php

return [
    'dependencies' => [
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\ZendView\ZendViewRendererFactory::class,
        ],
    ],

    'templates' => [
        'layout' => 'layout/default',
        'map' => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error'   => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths' => [
            'app'    => ['templates/app'],
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
        ]
    ]
];
