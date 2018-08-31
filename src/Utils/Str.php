<?php


namespace App\Utils;


class Str
{
    public static function contains(string $str, string $needle): bool
    {
        return strpos($str, $needle) !== false;
    }

    public static function random(int $length = 90): string
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }
}