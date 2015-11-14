<?php

namespace Asgrim\Service;

use DateTime;

class TalkService
{
    /**
     * @var string
     */
    private $talkDataFile;

    /**
     * @var array
     */
    private $talks;

    public function __construct($talkDataFile)
    {
        $this->talkDataFile = $talkDataFile;
    }

    /**
     * @return array
     */
    private function getTalks($inverseOrder = false)
    {
        if (!isset($this->talks)) {
            $this->talks = require $this->talkDataFile;
        }

        usort($this->talks, function($a, $b) use ($inverseOrder) {
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
     * @return array
     */
    public function getUpcomingTalks()
    {
        $now = new DateTime('00:00:00');
        return array_filter($this->getTalks(true), function ($talk) use ($now) {
            return $talk['date'] >= $now;
        });
    }

    /**
     * Get talks in the past.
     *
     * @return array
     */
    public function getPastTalks()
    {
        $now = new DateTime('00:00:00');
        return array_filter($this->getTalks(), function ($talk) use ($now) {
            return $talk['date'] < $now;
        });
    }
}
