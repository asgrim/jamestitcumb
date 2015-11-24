<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get('Zend\Expressive\Application');
$app->run();
