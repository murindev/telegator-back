<?php

namespace App\Console\Commands;

use App\Services\Engine\TaskEngine;
use Illuminate\Console\Command;

class ChannelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        new TaskEngine();
        return 0;
    }
}
