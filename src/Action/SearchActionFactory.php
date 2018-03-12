<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\PostService;
use Asgrim\Service\SearchWrapper;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

/**
 * @codeCoverageIgnore
 */
class SearchActionFactory
{
    public function __invoke(ContainerInterface $container) : SearchAction
    {
        return new SearchAction(
            $container->get(SearchWrapper::class),
            $container->get(PostService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
