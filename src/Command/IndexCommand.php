<?php

declare(strict_types=1);

namespace Asgrim\Command;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Common\Exceptions\TransportException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function sprintf;

final class IndexCommand extends Command
{
    public function __construct(private IndexerService $indexerService, private SearchWrapper $searchWrapper)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('index-posts')
            ->setDescription('Indexes the blog posts to create a cached list of them');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $postsIndexed = $this->indexerService->createIndex();

        if (! $postsIndexed) {
            $output->writeln('<error>No posts indexed. Possible cache failure.</error>');

            return 1;
        }

        $output->writeln(sprintf(
            '<info>Indexed %d post%s in the cache</info>',
            $postsIndexed,
            $postsIndexed === 1 ? '' : 's',
        ));

        try {
            $this->searchWrapper->indexAllPosts();
            $output->writeln('<info>Updated search index.</info>');

            return 0;
        } catch (TransportException $transportException) {
            $output->writeln('<error>Failed to connect to transport: ' . $transportException->getMessage() . '</error>');

            return 1;
        }
    }
}
