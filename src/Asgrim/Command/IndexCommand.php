<?php

namespace Asgrim\Command;

use Asgrim\Service\IndexerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexCommand extends Command
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    public function __construct(IndexerService $indexerService)
    {
        parent::__construct();
        $this->indexerService = $indexerService;
    }

    protected function configure()
    {
        $this->setName('index-posts')
            ->setDescription('Indexes the blog posts to create a cached list of them');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $postsIndexed = $this->indexerService->createIndex();

        if (!$postsIndexed) {
            $output->writeln('<error>No posts indexed. Possible cache failure.</error>');
            return;
        }

        $output->writeln(sprintf(
            '<info>Indexed %d post%s in the cache</info>',
            $postsIndexed,
            $postsIndexed == 1 ? '' : 's'
        ));
    }
}
