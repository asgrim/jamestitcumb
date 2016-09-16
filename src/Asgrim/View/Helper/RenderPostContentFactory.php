<?php
declare(strict_types=1);

namespace Asgrim\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Asgrim\Service\IndexerService;

/**
 * @codeCoverageIgnore
 */
class RenderPostContentFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : RenderPostContent
    {
        return new RenderPostContent($container->get(IndexerService::class));
    }
}
