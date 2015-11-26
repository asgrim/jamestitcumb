<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\ZendRouter::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => Asgrim\Action\AboutAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'feed',
            'path' => '/feed[/:format]',
            'middleware' => Asgrim\Action\FeedAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'posts',
            'path' => '/posts[/:slug]',
            'middleware' => Asgrim\Action\PostsAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'talks',
            'path' => '/talks',
            'middleware' => Asgrim\Action\TalksAction::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
