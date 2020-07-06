<?php

declare(strict_types=1);

namespace Asgrim\Handler;

use InvalidArgumentException;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface as TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class AboutHandler implements MiddlewareInterface
{
    private TemplateRenderer $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function process(Request $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new HtmlResponse($this->template->render('app::about', []));
    }
}
