<?php


namespace App\Utils;


class Str
{
    public static function contains(string $str, string $needle): bool
    {
        return strpos($str, $needle) !== false;
    }
}