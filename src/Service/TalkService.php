<?php

declare(strict_types=1);

namespace Asgrim\Service;

use DateTimeImmutable;
use function array_filter;
use function usort;

class TalkService
{
    /** @var string */
    private $talkDataFile;

    /** @var string[][]|string[][][]|bool[][] */
    private $talks;

    public function __construct(string $talkDataFile)
    {
        $this->talkDataFile = $talkDataFile;
    }

    /**
     * @return string[][]|string[][][]|bool[][]
     */
    private function getTalks(bool $inverseOrder = false) : array
    {
        if ($this->talks === null) {
            $this->talks = require $this->talkDataFile;
        }

        usort($this->talks, static function ($a, $b) use ($inverseOrder) {
            if ($a['date'] > $b['date']) {
                return $inverseOrder ? 1 : -1;
            }
            if ($a['date'] < $b['date']) {
                return $inverseOrder ? -1 : 1;
            }

            return 0;
        });

        return $this->talks;
    }

    /**
     * Get the upcoming talks.
     *
     * @return string[][]|string[][][]|bool[][]
     */
    public function getUpcomingTalks() : array
    {
        $now = new DateTimeImmutable('00:00:00');

        return array_filter($this->getTalks(true), static function ($talk) use ($now) {
            return $talk['date'] >= $now;
        });
    }

    /**
     * Get talks in the past.
     *
     * @return string[][]|string[][][]|bool[][]
     */
    public function getPastTalks() : array
    {
        $now = new DateTimeImmutable('00:00:00');

        return array_filter($this->getTalks(), static function ($talk) use ($now) {
            return $talk['date'] < $now;
        });
    }
}
