<?php

namespace Asgrim\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Asgrim\Service\IndexerService;

class RenderPostContentFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $serviceLocator->getServiceLocator();

        /** @var IndexerService $indexerService */
        $indexerService = $serviceManager->get(IndexerService::class);

        return new RenderPostContent($indexerService);
    }
}
