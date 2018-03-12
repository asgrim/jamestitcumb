<?php
declare(strict_types=1);

namespace Asgrim\Service;

use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class TalkServiceFactory
{
    public function __invoke(ContainerInterface $container) : TalkService
    {
        return new TalkService(__DIR__ . '/../../data/talks.php');
    }
}
