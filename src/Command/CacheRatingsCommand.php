<?php

declare(strict_types=1);

namespace Asgrim\Command;

use Asgrim\Service\Ratings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CacheRatingsCommand extends Command
{
    public function __construct(private Ratings $ratings)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('cache-ratings')
            ->setDescription('Caches Joind.in ratings');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->ratings->updateCachedRatings();

        return 0;
    }
}
