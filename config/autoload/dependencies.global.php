<?php
declare(strict_types=1);

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'factories' => [
            Asgrim\Action\AboutAction::class => Asgrim\Action\AboutActionFactory::class,
            Asgrim\Action\FeedAction::class => Asgrim\Action\FeedActionFactory::class,
            Asgrim\Action\PostsAction::class => Asgrim\Action\PostsActionFactory::class,
            Asgrim\Action\TalksAction::class => Asgrim\Action\TalksActionFactory::class,
            Asgrim\Action\SearchAction::class => Asgrim\Action\SearchActionFactory::class,

            Asgrim\Service\PostService::class => Asgrim\Service\PostServiceFactory::class,
            Asgrim\Service\IndexerService::class => Asgrim\Service\IndexerServiceFactory::class,
            Asgrim\Service\TalkService::class => Asgrim\Service\TalkServiceFactory::class,
            Asgrim\Service\FeedService::class => Asgrim\Service\FeedServiceFactory::class,
            Asgrim\Service\SearchWrapper::class => Asgrim\Service\SearchWrapperFactory::class,

            Application::class => ApplicationFactory::class,
            Zend\Expressive\Router\RouterInterface::class => \Zend\Expressive\Router\FastRouteRouterFactory::class,
            Helper\ServerUrlHelper::class => Zend\ServiceManager\Factory\InvokableFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
        ],
    ],
    'elasticsearch' => [
        'hosts' => [
        ],
    ],
];
