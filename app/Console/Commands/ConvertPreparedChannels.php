<?php

namespace App\Console\Commands;

use App\Jobs\ParseTelegramChannel;
use App\Models\ChannelsList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ConvertPreparedChannels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:prepared';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'for each ChannelList row run TelegramChannelParser';

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
        ChannelsList::all()->lazy()->each(function ($channel) {
            ParseTelegramChannel::dispatch($channel);
            Redis::set("log:ConvertPreparedChannels:{$channel->id}", $channel->toJson());
        });

        return 0;
    }
}
