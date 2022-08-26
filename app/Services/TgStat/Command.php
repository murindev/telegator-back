<?php

namespace App\Services\TgStat;

use App;
use Illuminate\Console\Command as BaseCommand;
use App\Services\TgStat\Exceptions\NotFound;

class Command extends BaseCommand
{
    protected TgStatService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = App::make(TgStatService::class);
    }

    public function safelyFetchParser($url)
    {
        try {
            return $this->service->fetchUrlAndInitParser($url);
        } catch (NotFound $e) {
            return false;
        }
    }

    public function safelyFetchUrl($url)
    {
        try {
            return $this->service->fetchUrl($url);
        } catch (NotFound $e) {
            return false;
        }
    }
}
