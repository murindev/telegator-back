<?php

namespace App\Services\TelegramBot\Jobs;

use App\Services\TelegramBot\Models\Updates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUpdate implements ShouldQueue //, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?Updates $update;

    public function __construct(Updates $update)
    {
        $this->update = $update;
        $this->onConnection('redis');
        $this->onQueue('ProcessUpdate');
    }

    public function handle()
    {
        $update = $this->update;

        // do something
    }
}
