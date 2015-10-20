<?php

namespace Asgrim;

use Asgrim\Service\IndexerService;
use Symfony\Component\Console\Application as BaseApplication;

class ConsoleApplication extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('James Titcumb', 'dev-master');

        $commands = [
            new Command\IndexCommand(
                new IndexerService(__DIR__ . '/../../data/posts/')
            ),
        ];

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
