<?php
declare(strict_types=1);

use Asgrim\Middleware\ClacksMiddleware;
use Asgrim\Middleware\ExceptionLoggingMiddleware;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Laminas\Stratigility\Middleware\ErrorHandler;

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
