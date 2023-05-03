<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\TalkService;
use Exception;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface as TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class TalksHandler implements MiddlewareInterface
{
    public function __construct(private TalkService $talkService, private TemplateRenderer $template)
    {
    }

    /** @throws Exception */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::talks', [
            'upcoming' => $this->talkService->getUpcomingTalks(),
            'past' => $this->talkService->getPastTalks(),
        ]));
    }
}
