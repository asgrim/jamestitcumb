<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Db\RatingsRepository;
use Asgrim\Service\Ratings;
use Asgrim\Service\TalkService;
use ColinODell\PsrTestLogger\TestLogger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

/** @covers \Asgrim\Service\Ratings */
final class RatingsTest extends TestCase
{
    private RatingsRepository&MockObject $repository;
    private TestLogger $logger;
    private Ratings $ratings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(RatingsRepository::class);
        $this->logger     = new TestLogger();

        $this->ratings = new Ratings(
            $this->repository,
            $this->logger,
            new TalkService(__DIR__ . '/../../fixture/talks.php'),
            $this->createMock(ClientInterface::class),
        );
    }

    public function testRatingForTalkReturnsEmptyStringWhenNoRatingStored(): void
    {
        $this->repository->method('findRatingForTalk')->willReturn(null);

        self::assertSame('', $this->ratings->ratingForTalk('https://joind.in/talk/view/1'));
    }

    public function testRatingForTalkRendersImageTag(): void
    {
        $this->repository->method('findRatingForTalk')->willReturn(4);

        self::assertSame(
            ' <img class="talk-card__rating" src="/images/ji-ratings/rating-4.gif" alt="Joind.in rating 4" />',
            $this->ratings->ratingForTalk('https://joind.in/talk/view/1'),
        );
    }

    public function testRatingForTalkReturnsEmptyStringAndWarnsWhenRatingAboveBounds(): void
    {
        $this->repository->method('findRatingForTalk')->willReturn(6);

        self::assertSame('', $this->ratings->ratingForTalk('https://joind.in/talk/view/1'));
        self::assertTrue($this->logger->hasWarningThatContains('beyond the allowed bounds'));
    }
}
