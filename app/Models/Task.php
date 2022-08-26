<?php

namespace App\Models;

use App\Filters\TaskQueryBuilder;
use App\Http\Requests\StoreTaskPriceRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task\TaskChannel;
use App\Models\Task\TaskMedia;
use App\Models\Task\TaskPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Eloquent;

/**
 * Class Task
 *
 * @package App\Models
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $status
 * @property string $execution_status
 * @property integer $version
 * @property Carbon $range_start_at
 * @property Carbon $range_end_at
 * @property boolean $publication
 * @property boolean $silence
 * @property float $cost
 * @property float $fine
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Campaign $campaign
 * @property-read Channel $channel
 * @property-read TaskContent $content
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereExecutionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereFine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task wherePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereRangeEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereRangeStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereSilence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereVersion($value)
 */
class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    const STATUS_NEW = 'new';
    const STATUS_INVITED = 'invited';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ACTIVE = 'active';

    protected $casts = [
        'range_start_at' => 'datetime',
        'range_end_at' => 'datetime',
        'publication' => 'integer',
        'silence' => 'integer',
        'version' => 'integer',
    ];

    protected $relations = ['channels']; // 'content', 'media', 'prices', 'campaign',

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(TaskChannel::class);
    }

    public function content(): HasOne
    {
        return $this->hasOne(TaskContent::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(TaskMedia::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(TaskPrice::class);
    }


    public function newEloquentBuilder($query): TaskQueryBuilder
    {
        return new TaskQueryBuilder($query);
    }


    public function createTask(StoreTaskRequest $request)
    {
        $task = $this->create($request->validated());
        $userBalanceUpdated = TaskChannel::createTaskChannels(\request('channels'), $task);
        TaskMedia::saveMedia($task->id);
        return $userBalanceUpdated;
    }

    public function index()
    {
        return $this->filter()->with($this->relations)->paginate(\request('rows'));
    }

    public function userTasks()
    {
        return $this->filter()->with($this->relations)->where('user_id', auth()->id())->paginate(\request('rows'));
    }

    public function allTasks()
    {
        return $this->filter()->with($this->relations)->paginate(\request('rows'));
    }



    /*
    brandAdvertPosts: true
    campaigns: undefined
    channelAdvertPosts: true
    channels:
        0: 6
        1: 5

    creatingAuthorsPost: true
    date_end: "2020-08-10"
    date_start: "2020-07-09"
    duration: "30"
    file_2:
    prices:
        brandAdvertPostForever: 15500
        brandAdvertPostOnce: 5500
        brandAdvertPostTwice: 10500
        channelAdvertPostForever: 15000
        channelAdvertPostOnce: 5000
        channelAdvertPostTwice: 10000

    silence: "10"
    time_end: "12:00"
    time_start: "12:00"
    title: "Заголовок поста"
    */


    /*    public function campaign(): BelongsTo
        {
            return $this->belongsTo(Campaign::class);
        }

        public function channel(): BelongsTo
        {
            return $this->belongsTo(Channel::class);
        }

        public function content()
        {
            return $this->hasOne(TaskContent::class)->withDefault();
        }

        public function migrate()
        {
            $campaign = $this->campaign;
            $channel = $this->channel;

            $this->version = $campaign->version;
            $this->range_start_at = $campaign->range_start_at;
            $this->range_end_at = $campaign->range_end_at;
            $this->publication = $campaign->publication;
            $this->silence = $campaign->silence;
            $this->cost = $channel->price;
            $this->fine = 0;

            if (!$this->exists) $this->save();

            if ($campaign->content->notEmpty()) {
                $content = $this->content;
                $content->fill(Arr::only($campaign->content->toArray(), $content->getFillable()));
            }
        }*/
}
