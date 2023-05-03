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

use function assert;

/** @covers \Asgrim\Command\IndexCommand */
final class IndexCommandTest extends TestCase
{
    public function testConfiguration(): void
    {
        $mockIndexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();
        assert($mockIndexer instanceof IndexerService || $mockIndexer instanceof MockObject);

        $mockSearch = $this->getMockBuilder(SearchWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        assert($mockSearch instanceof SearchWrapper || $mockSearch instanceof MockObject);

        $command = new IndexCommand($mockIndexer, $mockSearch);

        self::assertSame('index-posts', $command->getName());
        self::assertSame('Indexes the blog posts to create a cached list of them', $command->getDescription());
    }

    public function testExecuteCausesIndexerToCreateIndexAndOutputResultAndIndexSearch(): void
    {
        $mockIndexer = $this->createMock(IndexerService::class);
        assert($mockIndexer instanceof IndexerService || $mockIndexer instanceof MockObject);
        $mockIndexer->expects(self::once())
            ->method('createIndex')
            ->with()
            ->willReturn(3);

        $mockSearch = $this->createMock(SearchWrapper::class);
        assert($mockSearch instanceof SearchWrapper || $mockSearch instanceof MockObject);
        $mockSearch->expects(self::once())
            ->method('indexAllPosts');

        $mockInput = $this->createMock(InputInterface::class);

        $mockOutput = $this->createMock(OutputInterface::class);
        assert($mockOutput instanceof OutputInterface || $mockOutput instanceof MockObject);
        $mockOutput->expects(self::exactly(2))
            ->method('writeln')
            ->withConsecutive(
                ['<info>Indexed 3 posts in the cache</info>'],
                ['<info>Updated search index.</info>'],
            );

        $command = new IndexCommand($mockIndexer, $mockSearch);

        $command->execute($mockInput, $mockOutput);
    }

    public function testExecuteFailureToOutputMessage(): void
    {
        $mockIndexer = $this->createMock(IndexerService::class);
        assert($mockIndexer instanceof IndexerService || $mockIndexer instanceof MockObject);
        $mockIndexer->expects(self::once())
            ->method('createIndex')
            ->with()
            ->willReturn(0);

        $mockSearch = $this->createMock(SearchWrapper::class);
        assert($mockSearch instanceof SearchWrapper || $mockSearch instanceof MockObject);

        $mockInput = $this->createMock(InputInterface::class);
        assert($mockInput instanceof InputInterface || $mockInput instanceof MockObject);

        $mockOutput = $this->createMock(OutputInterface::class);
        assert($mockOutput instanceof OutputInterface || $mockOutput instanceof MockObject);

        $mockOutput->expects(self::once())
            ->method('writeln')
            ->with('<error>No posts indexed. Possible cache failure.</error>');

        $command = new IndexCommand($mockIndexer, $mockSearch);

        $command->execute($mockInput, $mockOutput);
    }
}
