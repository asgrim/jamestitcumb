<?php

declare(strict_types=1);

namespace Asgrim\Command;

use Asgrim\Service\Webmentions;
use DateTimeImmutable;
use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

use function assert;
use function is_string;
use function sprintf;

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
                'Fetches webmentions from webmention.io and stores them in Postgres. This is the ' .
                'only refresh mechanism - reads never fetch live, so this must be run periodically ' .
                '(e.g. via Heroku Scheduler) to keep webmentions up to date.',
            )
            ->addOption(
                'all',
                null,
                InputOption::VALUE_NONE,
                'Ignore the last successful sync and fetch every webmention webmention.io has ever recorded',
            )
            ->addOption(
                'since',
                null,
                InputOption::VALUE_REQUIRED,
                'Fetch webmentions received since this date/time instead of the last successful sync ' .
                '(any format accepted by DateTimeImmutable, e.g. "2026-01-01" or "-6 months")',
            );
    }

    #[Override]
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $all         = (bool) $input->getOption('all');
        $sinceOption = $input->getOption('since');
        assert($sinceOption === null || is_string($sinceOption));

        if ($all && $sinceOption !== null) {
            $output->writeln('<error>--all and --since cannot be used together.</error>');

            return 1;
        }

        $since = null;
        if ($sinceOption !== null) {
            try {
                $since = new DateTimeImmutable($sinceOption);
            } catch (Throwable) {
                $output->writeln(sprintf('<error>Could not parse --since value "%s".</error>', $sinceOption));

                return 1;
            }
        }

        $this->webmentions->refreshFromWebmentionIo($all, $since);

        $output->writeln('<info>Webmentions refreshed.</info>');

        return 0;
    }
}
