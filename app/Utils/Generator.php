<?php

namespace App\Utils;

use Illuminate\Support\Str;

class Generator
{
    const EMAIL_POSTFIX = '@telegator.dummy';

    public static function emailDummy($length = 16): string
    {
        return Str::random($length) . self::EMAIL_POSTFIX;
    }
}
