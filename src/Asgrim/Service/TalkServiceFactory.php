<?php

namespace Asgrim\Service;

use Interop\Container\ContainerInterface;

class TalkServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TalkService(__DIR__ . '/../../../data/talks.php');
    }
}
