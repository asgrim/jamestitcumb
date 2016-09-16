<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

/**
 * @codeCoverageIgnore
 */
class AboutActionFactory
{
    public function __invoke(ContainerInterface $container) : AboutAction
    {
        return new AboutAction(
            $container->get(TemplateRenderer::class)
        );
    }
}
