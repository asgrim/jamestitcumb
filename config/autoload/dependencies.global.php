<?php

return [
    'dependencies' => [
        'invokables' => [
        ],
        'factories' => [
            Asgrim\Action\AboutAction::class => Asgrim\Action\AboutActionFactory::class,
            Asgrim\Action\FeedAction::class => Asgrim\Action\FeedActionFactory::class,
            Asgrim\Action\PostsAction::class => Asgrim\Action\PostsActionFactory::class,
            Asgrim\Action\TalksAction::class => Asgrim\Action\TalksActionFactory::class,

            Asgrim\Service\PostService::class => Asgrim\Service\PostServiceFactory::class,
            Asgrim\Service\IndexerService::class => Asgrim\Service\IndexerServiceFactory::class,
            Asgrim\Service\TalkService::class => Asgrim\Service\TalkServiceFactory::class,
            Asgrim\Service\FeedService::class => Asgrim\Service\FeedServiceFactory::class,
            Asgrim\Service\SearchWrapper::class => Asgrim\Service\SearchWrapperFactory::class,

            Zend\Expressive\Application::class => Zend\Expressive\Container\ApplicationFactory::class,
        ],
    ],
];
