<?php

namespace App\Service;

class Duration
{

    public function getHours(int $duration): int
    {
        return floor($duration / 60);
    }

    public function getMinutes(int $duration): int
    {
        return ($duration % 60);
    }

    public function getHoursAndMinutesToString(int $duration, string $format = '%02d hours %02d minutes'): string
    {
        return sprintf($format, $this->getHours($duration), $this->getMinutes($duration));
    }

}