<?php
declare(strict_types=1);

namespace Asgrim\Action;

use Asgrim\Service\TalkService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
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

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::talks', [
            'upcoming' => $this->talkService->getUpcomingTalks(),
            'past' => $this->talkService->getPastTalks(),
        ]));
    }
}
