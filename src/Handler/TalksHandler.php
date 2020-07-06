<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\TalkService;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface as TemplateRenderer;

final class TalksHandler implements MiddlewareInterface
{
    /** @var TalkService */
    private $talkService;

    /** @var TemplateRenderer */
    private $template;

    public function __construct(TalkService $talkService, TemplateRenderer $template)
    {
        $this->talkService = $talkService;
        $this->template    = $template;
    }

    /** @throws Exception */
    public function process(Request $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::talks', [
            'upcoming' => $this->talkService->getUpcomingTalks(),
            'past' => $this->talkService->getPastTalks(),
        ]));
    }
}
