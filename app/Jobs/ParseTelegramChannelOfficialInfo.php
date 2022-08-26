<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Models\ChannelCategories;
use App\Models\ChannelsList;
use App\Processors\TgParser;
use App\Utils\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ParseTelegramChannelOfficialInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?ChannelsList $channel;

    /**
     * Create a new job instance.
     *
     * @param ChannelsList $channel
     */
    public function __construct(ChannelsList $channel)
    {
        $this->channel = $channel;
        $this->onConnection('redis');
        $this->onQueue('preparedChannelsGetInfo');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $channel = $this->channel;

        $data = TgParser::fetchChannelInfo(TgParser::constructValidChannelSlug($channel->slug, $channel->is_public));

        $isDeleted = is_null($data->title);// || is_null($data->subscribers);

        $catMap = [
            "тест" => [51, 50, 35, 39, 45],
            "Новости и СМИ" => [29],
            "Персональные каналы (блоги)" => [3],
            "Развлечения" => [35],
            "Москва" => [25],
            "Юмор" => [49],
            "Скидки/Акции" => [41],
            "Бизнес и финансы" => [2],
            "Мода и красота" => [24],
            "Наука и технологии" => [27, 45],
            "Маркетинг" => [21],
            "Региональные" => [36],
            "Санкт-Петербург" => [39],
            "Карьера" => [15],
            "Медиа" => [22],
            "Недвижимость" => [28],

        ];

        if (!($model = Channel::where('slug', $channel->slug)->first())) {
            $model = new Channel();
            $model->slug      = $channel->slug;
            $model->is_public = $channel->is_public;
        }

        if ($isDeleted) {
            if ($model->exists) {
                $model->is_deleted = true;
                $model->save();
            }
            return;
        }

        // impossible? or not?
        if ($model->exists && $model->is_deleted) $model->is_deleted = false;

        $model->contact  = $channel->contact;
        $model->subjects = $channel->subjects;
        $model->price    = $channel->post_price;
        $model->tg_link  = $data->link;
        $model->title    = $data->title;
        $model->avatar   = $data->image;

        if ($data->image) {
            $model->avatar = Helper::storePublicFile(
                $data->image,
                'avatars/channels/' . Str::random(6) . '/' . Str::random(6)
            );
        }

        $model->description = $data->description ?: '';
        $model->parsedNow();
        $model->save();

        foreach ($catMap[$channel->subjects] as $catId) {
            $l = new ChannelCategories();
            $l->channel_id = $model->id;
            $l->category_id = $catId;
            $l->save();
        }
    }
}
