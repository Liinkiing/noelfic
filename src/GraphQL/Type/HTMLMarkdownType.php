<?php

namespace App\GraphQL\Type;

class HTMLMarkdownType
{


    public static function serialize(string $value): ?string
    {
        return (new \Parsedown())->text($value);
    }

    public static function parseValue(string $value = null): ?string
    {
        return $value;
    }

    public static function parseLiteral($valueNode): ?string
    {
        return $valueNode->value;
    }
}
