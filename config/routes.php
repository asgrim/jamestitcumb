<?php
declare(strict_types=1);

/** @var \Zend\Expressive\Application $app */
$app->get('/', \Asgrim\Action\AboutAction::class, 'home');
$app->get('/feed[/{format}]', \Asgrim\Action\FeedAction::class, 'feed');
$app->get('/posts[/{slug}]', \Asgrim\Action\PostsAction::class, 'posts');
$app->get('/talks', \Asgrim\Action\TalksAction::class, 'talks');
$app->get('/search', \Asgrim\Action\SearchAction::class, 'search');
