<?php

namespace App\Models\Task;

use App\Filters\TaskChannelQueryBuilder;
use App\Http\Requests\UpdateTaskChannelRequest;
use App\Models\Campaign;
use App\Models\Channel;
use App\Models\Task;
use App\Models\Tgstat\TgstatPost;
use App\Models\User;
use App\Services\TelegramBot\TGBot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Task\TaskChannel
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $task_id
 * @property int $channel_id
 * @property int $price
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Task\TaskChannelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChannel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskChannel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $relations = ['channel.tgstat_stat', 'campaign', 'task.media', 'status', 'tgstat_post.tgstat_post_stat'];

    // relations

    public function channel(): HasOne
    {
        return $this->hasOne(Channel::class,'id','channel_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function status() : HasOne
    {
        return $this->hasOne(TaskStatus::class,'id','state');
    }

    public function tgstat_post(): HasOne
    {
        return $this->hasOne(TgstatPost::class,'link','post_link');
    }


    //

    public function newEloquentBuilder($query): TaskChannelQueryBuilder
    {
        return new TaskChannelQueryBuilder($query);
    }


    public static function createTaskChannels($arChannels,Task $task){
        $prices = 0;
        foreach ($arChannels as $channel) {
            $task->channels()->create([
                'user_id' => $task->user_id,
//                'campaign_id' => $task->campaign_id,
                'task_id' => $task->id,
                'channel_id' => $channel['id'],
                'price_type' => $channel['price_type'],
                'price' => $channel['price'],
            ]);

            TGBot::sendMessageByChannelId($channel['id'],'Вашему каналу предложили выполнить задачу в сервисе Telegator');

            $prices +=  $channel['price'];
        }

        return auth()->user()->balanceUpdate($prices);
    }

    public function taskChannelsIndex() {
        return $this->filter()->with($this->relations)->get();
    }

    public function taskChannelsPaginate() {
        return $this->filter()->with($this->relations)->paginate(request('rows') ?? 1000);
    }

    public function taskChannelUpdateOrCreate(UpdateTaskChannelRequest $request) {
        return $this->updateOrCreate(['id' => $request['id']],$request->toArray());
    }
}


