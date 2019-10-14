<?php
/** @noinspection UnusedFunctionResultInspection */
declare(strict_types=1);

use Asgrim\Handler;
use Zend\Expressive\Application;

return static function (Application $app): void {
    $app->get('/', Handler\AboutHandler::class, 'home');
    $app->get('/feed[/{format}]', Handler\FeedHandler::class, 'feed');
    $app->get('/posts[/{slug}]', Handler\PostsHandler::class, 'posts');
    $app->get('/talks', Handler\TalksHandler::class, 'talks');
    $app->get('/search', Handler\SearchHandler::class, 'search');
    $app->get('/training-workshops', Handler\TrainingHandler::class, 'training');
};
