<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use function PHPUnit\Framework\throwException;

class CheckRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check redis connection';

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
        try {
            $key = 'lol:kek';
            $value = 'chebureck';

            Redis::set($key, $value);
            if (Redis::get($key) !== $value) throwException(new \Exception('mistake'));

            $this->info('Redis - OK');
            return 1;
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return  0;
        }
    }
}
