<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\TalkService;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\Service\TalkService
 */
final class TalkServiceTest extends TestCase
{
    /** @var string */
    private static $talksFixture = __DIR__ . '/../../fixture/talks.php';

    public function testGetUpcomingTalks() : void
    {
        $talkService = new TalkService(self::$talksFixture);
        $upcoming    = $talkService->getUpcomingTalks();

        self::assertCount(1, $upcoming);
    }

    public function testGetPastTalks() : void
    {
        $talkService = new TalkService(self::$talksFixture);
        $past        = $talkService->getPastTalks();

        self::assertCount(3, $past);
    }
}
