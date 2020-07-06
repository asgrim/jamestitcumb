<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\TalkService;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Asgrim\Service\TalkService
 */
final class TalkServiceTest extends TestCase
{
    private static string $talksFixture = __DIR__ . '/../../fixture/talks.php';

    /** @throws Exception */
    public function testGetUpcomingTalks(): void
    {
        $upcoming = (new TalkService(self::$talksFixture))->getUpcomingTalks();

        self::assertCount(1, $upcoming);
    }

    /** @throws Exception */
    public function testGetPastTalks(): void
    {
        $past = (new TalkService(self::$talksFixture))->getPastTalks();

        self::assertCount(3, $past);
    }
}
