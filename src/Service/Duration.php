<?php

namespace App\Service;

class Duration
{

    public static function getHours(int $duration): int
    {
        return floor($duration / 60);
    }

    public static function getMinutes(int $duration): int
    {
        return ($duration % 60);
    }

    public function getHoursAndMinutesToString(int $duration, string $format = '%02d hours %02d minutes'): string
    {
        return sprintf($format, self::getHours($duration), self::getMinutes($duration));
    }

}