#!/usr/bin/env php
<?php

$autoloadPaths = array(
    'vendor/autoload.php',
);

foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        break;
    }
}

$app = new \Asgrim\ConsoleApplication();
$app->run();
