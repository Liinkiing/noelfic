<?php

namespace App\Utils;


class Math
{
    public static function clamp(float $current, float $min, float $max): float
    {
        return max($min, min($max, $current));
    }

}