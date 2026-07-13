<?php

declare(strict_types=1);

namespace Asgrim\Service;

/** @codeCoverageIgnore */
final class JobServiceFactory
{
    public function __invoke(): JobService
    {
        return new JobService(
            __DIR__ . '/../../data/experience.json',
            __DIR__ . '/../../public/images/companies',
            '/images/companies',
        );
    }
}
