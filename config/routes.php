<?php
declare(strict_types=1);

use Asgrim\Action;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', Action\AboutAction::class, 'home');
    $app->get('/feed[/{format}]', Action\FeedAction::class, 'feed');
    $app->get('/posts[/{slug}]', Action\PostsAction::class, 'posts');
    $app->get('/talks', Action\TalksAction::class, 'talks');
    $app->get('/search', Action\SearchAction::class, 'search');
    $app->get('/training-workshops', Action\TrainingAction::class, 'training');
};
