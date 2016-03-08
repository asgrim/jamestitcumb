<?php

namespace Asgrim\Command;

use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use Elasticsearch\Common\Exceptions\TransportException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexCommand extends Command
{
    /**
     * @var IndexerService
     */
    private $indexerService;

    /**
     * @var SearchWrapper
     */
    private $searchWrapper;

    public function __construct(IndexerService $indexerService, SearchWrapper $searchWrapper)
    {
        parent::__construct();
        $this->indexerService = $indexerService;
        $this->searchWrapper = $searchWrapper;
    }

    protected function configure()
    {
        $this->setName('index-posts')
            ->setDescription('Indexes the blog posts to create a cached list of them');
    }

    public function execute(InputInterface $input, OutputInterface $output)
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

        try {
            $this->searchWrapper->indexAllPosts();
            $output->writeln('<info>Updated search index.</info>');
        } catch (TransportException $transportException) {
            $output->writeln('<error>Failed to connect to transport: ' . $transportException->getMessage() . '</error>');
        }
    }
}
