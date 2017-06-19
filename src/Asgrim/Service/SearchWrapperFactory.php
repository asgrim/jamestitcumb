<?php
declare(strict_types=1);

namespace Asgrim\Service;

use Elasticsearch\ClientBuilder;
use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class SearchWrapperFactory
{
    public function __invoke(ContainerInterface $container) : SearchWrapper
    {
        $esClient = ClientBuilder::create()
            ->setHosts($container->get('config')['elasticsearch']['hosts'])
            ->build();

        return new SearchWrapper(
            $esClient,
            $container->get(IndexerService::class)
        );
    }
}
