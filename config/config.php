<?php

declare(strict_types=1);

use Asgrim\ConfigProvider as AsgrimConfig;
use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;
use Zend\Expressive\ConfigProvider as ExpressiveConfig;
use Zend\Expressive\Helper\ConfigProvider as ExpressiveHelperConfig;
use Zend\Expressive\Router\ConfigProvider as RouterConfig;
use Zend\Expressive\Router\FastRouteRouter\ConfigProvider as FastRouteRouterConfig;
use Zend\Expressive\ZendView\ConfigProvider as ZendViewConfig;
use Zend\HttpHandlerRunner\ConfigProvider as HttpHandlerRunnerConfig;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    FastRouteRouterConfig::class,
    HttpHandlerRunnerConfig::class,
    new ArrayProvider($cacheConfig),
    ExpressiveHelperConfig::class,
    ExpressiveConfig::class,
    RouterConfig::class,
    ZendViewConfig::class,
    AsgrimConfig::class,
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
