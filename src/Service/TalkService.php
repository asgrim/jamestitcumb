<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Value\Talk;
use DateTimeImmutable;
use Exception;
use Webmozart\Assert\Assert;

use function array_filter;
use function array_map;
use function usort;

class TalkService
{
    /** @var Talk[]|null */
    private array|null $talks = null;

    public function __construct(private string $talkDataFile)
    {
    }

    /** @return Talk[] */
    private function getTalks(bool $inverseOrder = false): array
    {
        if ($this->talks === null) {
            $talkArrayData = require $this->talkDataFile;
            Assert::isArray($talkArrayData);
            $this->talks = array_map(
                [Talk::class, 'fromArrayData'],
                $talkArrayData,
            );
        }

        // Note: sorting must be done on each invocation (not in the memoization) since order can vary each call
        usort($this->talks, static function (Talk $a, Talk $b) use ($inverseOrder) {
            if ($inverseOrder) {
                return $a->date() < $b->date() ? -1 : 1;
            }

            return $a->date() > $b->date() ? -1 : 1;
        });

        return $this->talks;
    }

    /**
     * Get the upcoming talks.
     *
     * @return Talk[]
     *
     * @throws Exception
     */
    public function getUpcomingTalks(): array
    {
        $now = new DateTimeImmutable('00:00:00');

        return array_filter($this->getTalks(true), static function (Talk $talk) use ($now) {
            return $talk->date() >= $now;
        });
    }

    /**
     * Get talks in the past.
     *
     * @return Talk[]
     *
     * @throws Exception
     */
    public function getPastTalks(): array
    {
        $now = new DateTimeImmutable('00:00:00');

        return array_filter($this->getTalks(), static function (Talk $talk) use ($now) {
            return $talk->date() < $now;
        });
    }
}
