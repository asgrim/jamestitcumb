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
    private function getTalks()
    {
        if (!isset($this->talks)) {
            $this->talks = require_once($this->talkDataFile);
        }
        return $this->talks;
    }

    /**
     * Get the upcoming talks
     *
     * @return array
     */
    public function getUpcomingTalks()
    {
        $now = new DateTime('00:00:00');
        return array_filter($this->getTalks(), function ($talk) use ($now) {
            return $talk['date'] >= $now;
        });
    }

    /**
     * Get talks in the past
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
