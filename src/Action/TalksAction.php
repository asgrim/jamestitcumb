<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\TalkService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

final class TalksAction implements MiddlewareInterface
{
    /**
     * @var TalkService
     */
    private $talkService;

    /**
     * @var TemplateRenderer
     */
    private $template;

    /**
     * @param TalkService $talkService
     * @param TemplateRenderer $template
     */
    public function __construct(TalkService $talkService, TemplateRenderer $template)
    {
        $this->talkService = $talkService;
        $this->template = $template;
    }

    public function process(Request $request, DelegateInterface $delegate) : HtmlResponse
    {
        return new HtmlResponse($this->template->render('app::talks', [
            'upcoming' => $this->talkService->getUpcomingTalks(),
            'past' => $this->talkService->getPastTalks(),
        ]));
    }
}
