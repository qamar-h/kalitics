<?php

namespace App\Service;

class WeekDetails
{
    private $weekNumber;
    private $year;

    public function __construct(int $weekNumber, int $year = null)
    {
        $this->weekNumber = $weekNumber;
        $this->year = $year;
    }

    public function getStartDate(): \DateTime
    {
        $date = new \DateTime();
        $year = $this->year === null ? date('Y') : $this->year;
        $date->setISODate($year, $this->weekNumber);
        return $date;
    }

    public function getEndDate(): \DateTime
    {
        return $this->getStartDate()
            ->modify('+6 days');
    }

}