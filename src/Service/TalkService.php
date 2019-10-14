<?php

declare(strict_types=1);

namespace Asgrim\Service;

use Asgrim\Value\Talk;
use DateTimeImmutable;
use Exception;
use function array_filter;
use function usort;

class TalkService
{
    /** @var string */
    private $talkDataFile;

    /** @var Talk[]|null */
    private $talks;

    public function __construct(string $talkDataFile)
    {
        $this->talkDataFile = $talkDataFile;
    }

    /**
     * @return Talk[]
     */
    private function getTalks(bool $inverseOrder = false) : array
    {
        if ($this->talks === null) {
            /** @psalm-suppress UnresolvableInclude */
            $this->talks = array_map(
                [Talk::class, 'fromArrayData'],
                require $this->talkDataFile
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
     * @throws Exception
     */
    public function getUpcomingTalks() : array
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
     * @throws Exception
     */
    public function getPastTalks() : array
    {
        $now = new DateTimeImmutable('00:00:00');

        return array_filter($this->getTalks(), static function (Talk $talk) use ($now) {
            return $talk->date() < $now;
        });
    }
}
