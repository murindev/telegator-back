<?php

namespace App\Exceptions;

use Exception;

class TgChannelNotFoundException extends Exception
{
    public function report() {
        \Log::debug('Телеграм канал не найден');
    }
}
