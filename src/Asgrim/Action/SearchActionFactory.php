<?php

namespace Asgrim\Action;

use Asgrim\Service\PostService;
use Interop\Container\ContainerInterface;
use Asgrim\Service\SearchWrapper;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class SearchActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new SearchAction(
            $container->get(SearchWrapper::class),
            $container->get(PostService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
