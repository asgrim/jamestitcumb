<?php

namespace Asgrim;

use Asgrim\Service\IndexerService;
use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    public function __construct()
    {
        parent::__construct('James Titcumb', 'dev-master');

        $commands = array(
            new Command\IndexCommand(
                new IndexerService(__DIR__ . '/../../data/posts/')
            ),
        );

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
