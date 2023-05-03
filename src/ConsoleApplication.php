<?php

declare(strict_types=1);

namespace Asgrim;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application as BaseApplication;

class ConsoleApplication extends BaseApplication
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct('James Titcumb', 'dev-master');

        $commands = [
            new Command\IndexCommand(
                $container->get(IndexerService::class),
                $container->get(SearchWrapper::class),
            ),
        ];

        foreach ($commands as $command) {
            /** @noinspection UnusedFunctionResultInspection */
            $this->add($command);
        }
    }
}
