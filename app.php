#!/usr/bin/env php
<?php

$autoloadPaths = [
    'vendor/autoload.php',
];

foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

$app = new \Asgrim\ConsoleApplication($container);
$app->run();
