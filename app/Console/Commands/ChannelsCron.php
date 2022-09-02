<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChannelsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channels:cron';

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
        shell_exec("bash -c 'python3 /var/www/ParsingForTelegator_2/main.py main'");
        return 0;
    }
}
