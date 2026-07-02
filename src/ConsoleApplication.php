<?php

declare(strict_types=1);

namespace Asgrim;

use Asgrim\Service\IndexerService;
use Asgrim\Service\Ratings;
use Asgrim\Service\SearchWrapper;
use Asgrim\Service\Webmentions;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application as BaseApplication;

final class ConsoleApplication extends BaseApplication
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct('James Titcumb', 'dev-master');

        $this->addCommands([
            new Command\IndexCommand(
                $container->get(IndexerService::class),
                $container->get(SearchWrapper::class),
            ),
            new Command\CacheRatingsCommand(
                $container->get(Ratings::class),
            ),
            new Command\CacheWebmentionsCommand(
                $container->get(Webmentions::class),
            ),
        ]);
    }
}
