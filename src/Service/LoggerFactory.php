<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class LoggerFactory
{
    public function __invoke() : LoggerInterface
    {
        $logger = new Logger('log');

        $logger->pushHandler(new ErrorLogHandler());

        return $logger;
    }
}
