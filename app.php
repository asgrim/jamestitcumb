#!/usr/bin/env php
<?php

declare(strict_types=1);

use Asgrim\ConsoleApplication;
use Psr\Container\ContainerInterface;

$autoloadPaths = [
    'vendor/autoload.php',
];

foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        /** @noinspection PhpIncludeInspection */
        require_once $path;
        break;
    }
}

/** @var ContainerInterface $container */
$container = require 'config/container.php';

$app = new ConsoleApplication($container);
$app->run();
