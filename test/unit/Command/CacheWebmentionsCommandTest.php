<?php

declare(strict_types=1);

namespace AsgrimTest\Command;

use Asgrim\Command\CacheWebmentionsCommand;
use Asgrim\Service\Webmentions;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/** @covers \Asgrim\Command\CacheWebmentionsCommand */
final class CacheWebmentionsCommandTest extends TestCase
{
    private Webmentions&MockObject $webmentions;
    private InputInterface&MockObject $input;
    private OutputInterface&MockObject $output;
    private CacheWebmentionsCommand $command;

    protected function setUp(): void
    {
        parent::setUp();

        $this->webmentions = $this->createMock(Webmentions::class);
        $this->input       = $this->createMock(InputInterface::class);
        $this->output      = $this->createMock(OutputInterface::class);
        $this->command     = new CacheWebmentionsCommand($this->webmentions);
    }

    public function testExecuteWithNoOptionsRefreshesSinceLastSync(): void
    {
        $this->input->method('getOption')->willReturnMap([
            ['all', false],
            ['since', null],
        ]);

        $this->webmentions->expects(self::once())
            ->method('refreshFromWebmentionIo')
            ->with(false, null);

        self::assertSame(0, $this->command->execute($this->input, $this->output));
    }

    public function testExecuteWithAllOptionRefreshesEverything(): void
    {
        $this->input->method('getOption')->willReturnMap([
            ['all', true],
            ['since', null],
        ]);

        $this->webmentions->expects(self::once())
            ->method('refreshFromWebmentionIo')
            ->with(true, null);

        self::assertSame(0, $this->command->execute($this->input, $this->output));
    }

    public function testExecuteWithSinceOptionRefreshesFromThatDate(): void
    {
        $this->input->method('getOption')->willReturnMap([
            ['all', false],
            ['since', '2026-01-01'],
        ]);

        $this->webmentions->expects(self::once())
            ->method('refreshFromWebmentionIo')
            ->with(false, self::equalTo(new DateTimeImmutable('2026-01-01')));

        self::assertSame(0, $this->command->execute($this->input, $this->output));
    }

    public function testExecuteWithBothAllAndSinceIsAnError(): void
    {
        $this->input->method('getOption')->willReturnMap([
            ['all', true],
            ['since', '2026-01-01'],
        ]);

        $this->webmentions->expects(self::never())->method('refreshFromWebmentionIo');
        $this->output->expects(self::once())
            ->method('writeln')
            ->with('<error>--all and --since cannot be used together.</error>');

        self::assertSame(1, $this->command->execute($this->input, $this->output));
    }

    public function testExecuteWithUnparsableSinceIsAnError(): void
    {
        $this->input->method('getOption')->willReturnMap([
            ['all', false],
            ['since', 'not-a-date'],
        ]);

        $this->webmentions->expects(self::never())->method('refreshFromWebmentionIo');
        $this->output->expects(self::once())
            ->method('writeln')
            ->with('<error>Could not parse --since value "not-a-date".</error>');

        self::assertSame(1, $this->command->execute($this->input, $this->output));
    }
}
