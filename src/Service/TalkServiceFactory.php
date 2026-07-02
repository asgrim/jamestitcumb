<?php

declare(strict_types=1);

namespace Asgrim\Service;

/** @codeCoverageIgnore */
final class TalkServiceFactory
{
    public function __invoke(): TalkService
    {
        return new TalkService(__DIR__ . '/../../data/talks.php');
    }
}
