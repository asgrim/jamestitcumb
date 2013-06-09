<?php

chdir(dirname(__DIR__));

$loader = require_once('vendor/autoload.php');
$loader->add('Asgrim', 'app/src');

$app = new Asgrim\Application('app/config/config.yml');
$app->run();
