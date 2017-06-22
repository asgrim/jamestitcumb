<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

(function () {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = require __DIR__ . '/../config/container.php';

    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    require __DIR__ . '/../config/pipeline.php';
    require __DIR__ . '/../config/routes.php';
    $app->run();
})();
