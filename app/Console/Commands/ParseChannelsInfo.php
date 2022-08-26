<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Services\TgStat\Jobs\ParseTgStatChannelInfo;
use Illuminate\Console\Command;

class ParseChannelsInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:channels';

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
        Channel::where('is_deleted', 0)->get()->lazy()->each(function ($channel) {
            $channel->tg_stat_channel->save();
            ParseTgStatChannelInfo::dispatch($channel->tg_stat_channel)->delay(1);
        });

        return 0;
    }
}
