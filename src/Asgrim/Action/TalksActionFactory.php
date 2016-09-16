<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Interop\Container\ContainerInterface;
use Asgrim\Service\TalkService;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

/**
 * @codeCoverageIgnore
 */
class TalksActionFactory
{
    public function __invoke(ContainerInterface $container) : TalksAction
    {
        return new TalksAction(
            $container->get(TalkService::class),
            $container->get(TemplateRenderer::class)
        );
    }
}
