<?php

namespace App\Utils;

class Checker
{
    public static function isNullableArray(array $data): bool
    {
        foreach ($data as $key => $item) {
            if (is_numeric($item) && $item != 0) return false;
            if (is_string($item) && trim($item) !== '')  return false;
            if (is_array($item) && count($item) && !self::isNullableArray($item)) return false;
        }
        return true;
    }
}
