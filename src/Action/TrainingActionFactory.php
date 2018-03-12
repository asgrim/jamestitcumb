<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class TrainingActionFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : TrainingAction
    {
        return new TrainingAction(
            $container->get(TemplateRenderer::class)
        );
    }
}
