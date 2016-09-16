<?php
declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\TalkService;

/**
 * @covers \Asgrim\Service\TalkService
 */
final class TalkServiceTest extends \PHPUnit_Framework_TestCase
{
    private static $talksFixture = __DIR__ . '/../../fixture/talks.php';

    public function testGetUpcomingTalks()
    {
        $talkService = new TalkService(self::$talksFixture);
        $upcoming = $talkService->getUpcomingTalks();

        self::assertCount(1, $upcoming);
    }

    public function testGetPastTalks()
    {
        $talkService = new TalkService(self::$talksFixture);
        $past = $talkService->getPastTalks();

        self::assertCount(3, $past);
    }
}
