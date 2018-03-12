<?php
declare(strict_types=1);

use Asgrim\Handler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', Handler\AboutHandler::class, 'home');
    $app->get('/feed[/{format}]', Handler\FeedHandler::class, 'feed');
    $app->get('/posts[/{slug}]', Handler\PostsHandler::class, 'posts');
    $app->get('/talks', Handler\TalksHandler::class, 'talks');
    $app->get('/search', Handler\SearchHandler::class, 'search');
    $app->get('/training-workshops', Handler\TrainingHandler::class, 'training');
};
