<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use Asgrim\Service\JobService;
use JsonException;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface as TemplateRenderer;
use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ExperienceHandler implements MiddlewareInterface
{
    public function __construct(private JobService $jobService, private TemplateRenderer $template)
    {
    }

    /** @throws JsonException */
    #[Override]
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::experience', [
            'jobs' => $this->jobService->getJobs(),
            'tagCounts' => $this->jobService->getTagCounts(),
        ]));
    }
}
