<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Value\Job;
use JsonException;
use Webmozart\Assert\Assert;

use function array_map;
use function file_exists;
use function file_get_contents;
use function json_decode;
use function ksort;
use function rtrim;
use function usort;

use const JSON_THROW_ON_ERROR;
use const SORT_FLAG_CASE;
use const SORT_NATURAL;

final class JobService
{
    /** @var Job[]|null */
    private array|null $jobs = null;

    public function __construct(
        private string $jobDataFile,
        private string $logoDirectory,
        private string $logoWebPath,
    ) {
    }

    /**
     * @return Job[]
     *
     * @throws JsonException
     */
    public function getJobs(): array
    {
        if ($this->jobs === null) {
            $contents = file_get_contents($this->jobDataFile);
            Assert::string($contents);

            $jobArrayData = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
            Assert::isArray($jobArrayData);

            $this->jobs = array_map(
                fn (array $jobData): Job => Job::fromArrayData($jobData, $this->resolveLogoUrl($jobData)),
                $jobArrayData,
            );

            // Current jobs (no end date) sort first; ties (including between current jobs)
            // preserve the original order from the data file, relying on usort's stability.
            usort($this->jobs, static function (Job $a, Job $b) {
                $aEnd = $a->end();
                $bEnd = $b->end();

                if ($aEnd === null || $bEnd === null) {
                    return ($bEnd === null) <=> ($aEnd === null);
                }

                return $bEnd <=> $aEnd;
            });
        }

        return $this->jobs;
    }

    /**
     * @return array<string, int> Tag name to number of jobs it appears on, sorted alphabetically.
     *
     * @throws JsonException
     */
    public function getTagCounts(): array
    {
        $counts = [];
        foreach ($this->getJobs() as $job) {
            foreach ($job->tags() as $tag) {
                $counts[$tag] = ($counts[$tag] ?? 0) + 1;
            }
        }

        ksort($counts, SORT_NATURAL | SORT_FLAG_CASE);

        return $counts;
    }

    /** @param mixed[] $jobData */
    private function resolveLogoUrl(array $jobData): string|null
    {
        $logo = $jobData['logo'] ?? null;
        if ($logo === null) {
            return null;
        }

        Assert::string($logo);

        if (! file_exists(rtrim($this->logoDirectory, '/') . '/' . $logo)) {
            return null;
        }

        return rtrim($this->logoWebPath, '/') . '/' . $logo;
    }
}
