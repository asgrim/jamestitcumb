<?php

declare(strict_types=1);

namespace AsgrimTest\Command;

use Asgrim\Command\IndexCommand;
use Asgrim\Service\IndexerService;
use Asgrim\Service\SearchWrapper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @covers \Asgrim\Command\IndexCommand
 */
final class IndexCommandTest extends TestCase
{
    public function testConfiguration() : void
    {
        /** @var IndexerService|MockObject $mockIndexer */
        $mockIndexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var SearchWrapper|MockObject $mockSearch */
        $mockSearch = $this->getMockBuilder(SearchWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $command = new IndexCommand($mockIndexer, $mockSearch);

        self::assertSame('index-posts', $command->getName());
        self::assertSame('Indexes the blog posts to create a cached list of them', $command->getDescription());
    }

    public function testExecuteCausesIndexerToCreateIndexAndOutputResultAndIndexSearch() : void
    {
        /** @var IndexerService|MockObject $mockIndexer */
        $mockIndexer = $this->createMock(IndexerService::class);
        $mockIndexer->expects(self::once())
            ->method('createIndex')
            ->with()
            ->willReturn(3);

        /** @var SearchWrapper|MockObject $mockSearch */
        $mockSearch = $this->createMock(SearchWrapper::class);
        $mockSearch->expects(self::once())
            ->method('indexAllPosts');

        /** @var InputInterface|MockObject $mockInput */
        $mockInput = $this->createMock(InputInterface::class);

        /** @var OutputInterface|MockObject $mockOutput */
        $mockOutput = $this->createMock(OutputInterface::class);
        $mockOutput->expects(self::at(0))
            ->method('writeln')
            ->with('<info>Indexed 3 posts in the cache</info>');
        $mockOutput->expects(self::at(1))
            ->method('writeln')
            ->with('<info>Updated search index.</info>');

        $command = new IndexCommand($mockIndexer, $mockSearch);

        $command->execute($mockInput, $mockOutput);
    }

    public function testExecuteFailureToOutputMessage() : void
    {
        /** @var IndexerService|MockObject $mockIndexer */
        $mockIndexer = $this->createMock(IndexerService::class);
        $mockIndexer->expects(self::once())
            ->method('createIndex')
            ->with()
            ->willReturn(0);

        /** @var SearchWrapper|MockObject $mockSearch */
        $mockSearch = $this->createMock(SearchWrapper::class);

        /** @var InputInterface|MockObject $mockInput */
        $mockInput = $this->createMock(InputInterface::class);

        /** @var OutputInterface|MockObject $mockOutput */
        $mockOutput = $this->createMock(OutputInterface::class);

        $mockOutput->expects(self::once())
            ->method('writeln')
            ->with('<error>No posts indexed. Possible cache failure.</error>');

        $command = new IndexCommand($mockIndexer, $mockSearch);

        $command->execute($mockInput, $mockOutput);
    }
}
