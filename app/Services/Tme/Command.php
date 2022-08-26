<?php

namespace App\Services\Tme;

use App;
use Illuminate\Console\Command as BaseCommand;
use App\Services\Tme\Exceptions\NotFound;

class Command extends BaseCommand
{
    protected TmeService $service;

    public function __construct()
    {
        parent::__construct();
        $this->service = App::make(TmeService::class);
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
