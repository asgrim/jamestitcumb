<?php

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Asgrim\Service\TalkService;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class TalksActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TalksAction(
            $container->get(TalkService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
