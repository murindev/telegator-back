<?php

namespace App\Jobs;

use App\Models\ChannelsList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ParseTelegramChannel implements ShouldQueue
    //, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?ChannelsList $channel;

    /**
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 30;

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId(): string
    {
        return $this->channel->id;
    }

    /**
     * Create a new job instance.
     *
     * @param ChannelsList $channel
     */
    public function __construct(ChannelsList $channel)
    {
        $this->channel = $channel;
        $this->onConnection('redis');
        $this->onQueue('preparedChannels');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Bus::chain([
            new ParseTelegramChannelOfficialInfo($this->channel),
        ])->dispatch();
    }
}
