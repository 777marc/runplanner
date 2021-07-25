<?php

namespace App\Services;

class CalcService
{
    public static function calculatePace($distance, $duration)
    {
        return ($duration / 60) / $distance;
    }
}
