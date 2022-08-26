<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CheckDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check DB connection';

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
        if (DB::connection()->getDatabaseName())  {
            $this->info('OK');
            return 1;
        } else {
            $this->error('No connection');
            return 0;
        }
    }
}
