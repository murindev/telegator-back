<?php

namespace App\Console;

use App\Console\Commands\ChannelCron;
use App\Console\Commands\ChannelsCron;
use App\Console\Commands\DemoCron;
use App\Services\TgStat\Commands\CacheChannelHtml;
use App\Services\TgStat\Commands\FetchUrl;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        FetchUrl::class,
        CacheChannelHtml::class,
        DemoCron::class,
        ChannelCron::class,
        ChannelsCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if ($this->app->environment('local')) {
            $schedule->command('telescope:prune')->daily();
        }

        $schedule->command('channel:cron')->hourly();
        $schedule->command('channels:cron')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
