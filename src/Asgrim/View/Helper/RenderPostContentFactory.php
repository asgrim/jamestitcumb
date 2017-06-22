<?php
declare(strict_types=1);

namespace Asgrim\View\Helper;

use Asgrim\Service\IndexerService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

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
