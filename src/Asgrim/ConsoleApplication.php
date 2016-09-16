<?php
declare(strict_types=1);

namespace Asgrim;

use Symfony\Component\Console\Application as BaseApplication;
use Interop\Container\ContainerInterface;
use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;

class ConsoleApplication extends BaseApplication
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct('James Titcumb', 'dev-master');

        $commands = [
            new Command\IndexCommand(
                $container->get(IndexerService::class),
                $container->get(SearchWrapper::class)
            ),
        ];

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
