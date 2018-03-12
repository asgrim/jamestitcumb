<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\PostService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

/**
 * @codeCoverageIgnore
 */
class PostsActionFactory
{
    public function __invoke(ContainerInterface $container) : PostsAction
    {
        return new PostsAction(
            $container->get(PostService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
