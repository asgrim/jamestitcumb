<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\TalkService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface as TemplateRenderer;

class TalksAction
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

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return HtmlResponse
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : HtmlResponse
    {
        return new HtmlResponse($this->template->render('app::talks', [
            'upcoming' => $this->talkService->getUpcomingTalks(),
            'past' => $this->talkService->getPastTalks(),
        ]));
    }
}
