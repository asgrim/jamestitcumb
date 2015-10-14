<?php

namespace AsgrimTest\Command;

use Asgrim\Command\IndexCommand;
use Asgrim\Service\IndexerService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IndexCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testConfiguration()
    {
        /** @var IndexerService|\PHPUnit_Framework_MockObject_MockObject $mockIndexer */
        $mockIndexer = $this->getMockBuilder(IndexerService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $command = new IndexCommand($mockIndexer);

        $this->assertSame('index-posts', $command->getName());
        $this->assertSame('Indexes the blog posts to create a cached list of them', $command->getDescription());
    }

    public function testExecuteCausesIndexerToCreateIndexAndOutputResult()
    {
        /** @var IndexerService|\PHPUnit_Framework_MockObject_MockObject $mockIndexer */
        $mockIndexer = $this->getMockBuilder(IndexerService::class)
            ->setMethods(['createIndex'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockIndexer->expects($this->once())
            ->method('createIndex')
            ->with()
            ->will($this->returnValue(3));

        /** @var InputInterface|\PHPUnit_Framework_MockObject_MockObject $mockInput */
        $mockInput = $this->getMockBuilder(InputInterface::class)
            ->getMockForAbstractClass();

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $mockOutput */
        $mockOutput = $this->getMockBuilder(OutputInterface::class)
            ->setMethods(['writeln'])
            ->getMockForAbstractClass();

        $mockOutput->expects($this->once())
            ->method('writeln')
            ->with('<info>Indexed 3 posts in the cache</info>');

        $command = new IndexCommand($mockIndexer);

        $command->execute($mockInput, $mockOutput);
    }

    public function testExecuteFailureToOutputMessage()
    {
        /** @var IndexerService|\PHPUnit_Framework_MockObject_MockObject $mockIndexer */
        $mockIndexer = $this->getMockBuilder(IndexerService::class)
            ->setMethods(['createIndex'])
            ->disableOriginalConstructor()
            ->getMock();

        $mockIndexer->expects($this->once())
            ->method('createIndex')
            ->with()
            ->will($this->returnValue(0));

        /** @var InputInterface|\PHPUnit_Framework_MockObject_MockObject $mockInput */
        $mockInput = $this->getMockBuilder(InputInterface::class)
            ->getMockForAbstractClass();

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $mockOutput */
        $mockOutput = $this->getMockBuilder(OutputInterface::class)
            ->setMethods(['writeln'])
            ->getMockForAbstractClass();

        $mockOutput->expects($this->once())
            ->method('writeln')
            ->with('<error>No posts indexed. Possible cache failure.</error>');

        $command = new IndexCommand($mockIndexer);

        $command->execute($mockInput, $mockOutput);
    }
}
