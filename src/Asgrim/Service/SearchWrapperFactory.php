<?php

namespace Asgrim\Service;

use Elasticsearch\ClientBuilder;
use Interop\Container\ContainerInterface;

class SearchWrapperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $esClient = ClientBuilder::create()->build();

        return new SearchWrapper(
            $esClient,
            $container->get(IndexerService::class)
        );
    }
}
