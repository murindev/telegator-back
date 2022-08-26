<?php

namespace App\Services\TgStat\Jobs;

use App\Services\TgStat\Exceptions\UndefinedChannelSlug;
use App\Services\TgStat\Models\TgStatChannel;
use App\Services\TgStat\TgStatService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class ParseTgStatChannelInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?TgStatChannel $channel;

    /**
     * Create a new job instance.
     *
     * @param TgStatChannel $channel
     */
    public function __construct(TgStatChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Execute the job.
     *
     * @param TgStatService $parser
     *
     * @return void
     */
    public function handle(TgStatService $parser)
    {
        $channel = $this->channel;

        if (!$channel->slug) $this->fail(new UndefinedChannelSlug('undefined TgStats channel slug'));

        $data = $parser->fetchChannelInfo($channel);

        if ($data) $channel->fill($data);
        else $channel->status = false;

        $channel->save();
    }
}
