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

    private function getTalks()
    {
        if (!isset($this->talks)) {
            $this->talks = require_once($this->talkDataFile);
        }
        return $this->talks;
    }

    public function getUpcomingTalks()
    {
        $now = new DateTime('23:59:59');
        return array_filter($this->getTalks(), function ($talk) use ($now) {
            return $talk['date'] >= $now;
        });
    }

    public function getPastTalks()
    {
        $now = new DateTime('23:59:59');
        return array_filter($this->getTalks(), function ($talk) use ($now) {
            return $talk['date'] < $now;
        });
    }
}
