<?php

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class AboutActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AboutAction(
            $container->get(TemplateRenderer::class)
        );
    }
}
