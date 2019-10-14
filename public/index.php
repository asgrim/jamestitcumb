<?php
declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

(static function () {
    /** @var ContainerInterface $container */
    $container = require __DIR__ . '/../config/container.php';

    /** @var Application $app */
    $app = $container->get(Application::class);
    (require __DIR__ . '/../config/pipeline.php')($app);
    (require __DIR__ . '/../config/routes.php')($app);
    $app->run();
})();
