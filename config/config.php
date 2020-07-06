<?php

declare(strict_types=1);

use Asgrim\ConfigProvider as AsgrimConfig;
use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\Diactoros\ConfigProvider as DiactorosConfig;
use Mezzio\ConfigProvider as ExpressiveConfig;
use Mezzio\Helper\ConfigProvider as ExpressiveHelperConfig;
use Mezzio\Router\ConfigProvider as RouterConfig;
use Mezzio\Router\FastRouteRouter\ConfigProvider as FastRouteRouterConfig;
use Mezzio\LaminasView\ConfigProvider as LaminasViewConfig;
use Laminas\HttpHandlerRunner\ConfigProvider as HttpHandlerRunnerConfig;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'data/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    DiactorosConfig::class,
    FastRouteRouterConfig::class,
    HttpHandlerRunnerConfig::class,
    new ArrayProvider($cacheConfig),
    ExpressiveHelperConfig::class,
    ExpressiveConfig::class,
    RouterConfig::class,
    LaminasViewConfig::class,
    AsgrimConfig::class,
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();
