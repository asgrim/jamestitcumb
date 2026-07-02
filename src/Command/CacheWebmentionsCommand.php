<?php

declare(strict_types=1);

namespace Asgrim\Command;

use Asgrim\Service\Webmentions;
use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CacheWebmentionsCommand extends Command
{
    public function __construct(private Webmentions $webmentions)
    {
        parent::__construct();
    }

    #[Override]
    protected function configure(): void
    {
        $this->setName('cache-webmentions')
            ->setDescription(
                'Warms the local webmentions cache (optional dev convenience - ' .
                'mentionsForUrl() self-refreshes lazily at request time, so this is not required in production).',
            );
    }

    #[Override]
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->webmentions->forceRefresh();

        $output->writeln('<info>Webmentions cache refreshed.</info>');

        return 0;
    }
}
