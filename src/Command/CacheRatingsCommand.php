<?php

declare(strict_types=1);

namespace Asgrim\Command;

use Asgrim\Service\Ratings;
use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class CacheRatingsCommand extends Command
{
    public function __construct(private Ratings $ratings)
    {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->setName('cache-ratings')
            ->setDescription('Caches Joind.in ratings for talks in the last 3 months')
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'Rebuild ratings for every past joind.in-linked talk, not just the last 3 months',
            );
    }

    #[Override]
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->ratings->updateCachedRatings((bool) $input->getOption('all'));

        return 0;
    }
}
