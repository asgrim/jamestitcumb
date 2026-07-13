<?php

declare(strict_types=1);

namespace AsgrimTest\Service;

use Asgrim\Service\JobService;
use JsonException;
use PHPUnit\Framework\TestCase;

/** @covers \Asgrim\Service\JobService */
final class JobServiceTest extends TestCase
{
    private static string $jobsFixture    = __DIR__ . '/../../fixture/experience.json';
    private static string $logoFixtureDir = __DIR__ . '/../../fixture/logos';

    /** @throws JsonException */
    public function testGetJobsReturnsAllJobs(): void
    {
        $jobs = $this->createJobService()->getJobs();

        self::assertCount(4, $jobs);
    }

    /** @throws JsonException */
    public function testCurrentJobsAreSortedFirstPreservingDataFileOrder(): void
    {
        $jobs = $this->createJobService()->getJobs();

        self::assertTrue($jobs[0]->isCurrent());
        self::assertTrue($jobs[1]->isCurrent());
        self::assertSame('Current Co A', $jobs[0]->company());
        self::assertSame('Current Co B', $jobs[1]->company());
    }

    /** @throws JsonException */
    public function testPastJobsAreSortedByEndDateDescending(): void
    {
        $jobs = $this->createJobService()->getJobs();

        self::assertFalse($jobs[2]->isCurrent());
        self::assertFalse($jobs[3]->isCurrent());
        self::assertSame('Recent Past Co', $jobs[2]->company());
        self::assertSame('Older Past Co', $jobs[3]->company());
    }

    /** @throws JsonException */
    public function testGetTagCountsCountsAndSortsTagsAlphabetically(): void
    {
        $tagCounts = $this->createJobService()->getTagCounts();

        self::assertSame(['Java' => 1, 'PHP' => 2], $tagCounts);
    }

    /** @throws JsonException */
    public function testLogoUrlIsResolvedWhenFileExists(): void
    {
        $jobs = $this->createJobService()->getJobs();

        self::assertSame('/images/companies/current.png', $jobs[0]->logoUrl());
    }

    /** @throws JsonException */
    public function testLogoUrlIsNullWhenFileDoesNotExist(): void
    {
        $jobs = $this->createJobService()->getJobs();

        self::assertNull($jobs[1]->logoUrl());
    }

    private function createJobService(): JobService
    {
        return new JobService(self::$jobsFixture, self::$logoFixtureDir, '/images/companies');
    }
}
