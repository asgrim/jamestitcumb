<?php
declare(strict_types=1);

namespace Asgrim;

use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Zend\ServiceManager\Factory\InvokableFactory;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'view_helpers' => $this->getViewHelpers(),
            'templates' => $this->getTemplates(),
            'elasticsearch' => [
                'hosts' => [
                ],
            ],
        ];
    }

    private function getDependencies(): array
    {
        return [
            'abstract_factories' => [
                ReflectionBasedAbstractFactory::class,
            ],
            'factories' => [
                Handler\AboutHandler::class => ReflectionBasedAbstractFactory::class,
                Handler\FeedHandler::class => ReflectionBasedAbstractFactory::class,
                Handler\PostsHandler::class => ReflectionBasedAbstractFactory::class,
                Handler\TalksHandler::class => ReflectionBasedAbstractFactory::class,
                Handler\SearchHandler::class => ReflectionBasedAbstractFactory::class,
                Handler\TrainingHandler::class => ReflectionBasedAbstractFactory::class,
                Service\PostService::class => ReflectionBasedAbstractFactory::class,
                Service\IndexerService::class => Service\IndexerServiceFactory::class,
                Service\TalkService::class => Service\TalkServiceFactory::class,
                Service\FeedService::class => ReflectionBasedAbstractFactory::class,
                Service\SearchWrapper::class => Service\SearchWrapperFactory::class,
            ],
        ];
    }

    private function getViewHelpers(): array
    {
        return [
            'factories' => [
                View\Helper\RenderPostContent::class => ReflectionBasedAbstractFactory::class,
                View\Helper\RenderTalk::class => InvokableFactory::class,
            ],
            'aliases' => [
                'renderTalk' => View\Helper\RenderTalk::class,
                'renderPostContent' => View\Helper\RenderPostContent::class,
            ],
        ];
    }

    private function getTemplates(): array
    {
        return [
            'layout' => 'layout/default',
            'map' => [
                'layout/default' => 'templates/layout/default.phtml',
                'error/error'   => 'templates/error/error.phtml',
                'error/404'      => 'templates/error/404.phtml',
            ],
            'paths' => [
                'app' => ['templates/app'],
                'partial' => ['templates/partial'],
                'layout' => ['templates/layout'],
                'error' => ['templates/error'],
            ],
        ];
    }
}
