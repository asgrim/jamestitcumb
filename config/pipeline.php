<?php
declare(strict_types=1);

use Asgrim\Middleware\ClacksMiddleware;
use Asgrim\Middleware\ExceptionLoggingMiddleware;
use Zend\Expressive\Application;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Stratigility\Middleware\ErrorHandler;

return static function (Application $app): void {
    $app->pipe(ErrorHandler::class);
    $app->pipe(ExceptionLoggingMiddleware::class);
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe(RouteMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);
    $app->pipe(ClacksMiddleware::class);
    $app->pipe(DispatchMiddleware::class);
    $app->pipe(NotFoundHandler::class);
};
