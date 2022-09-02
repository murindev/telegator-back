<?php

namespace App\Models;

use App\Filters\CampaignQueryBuilder;
use App\Http\Requests\StoreCampaignChannelRequest;
use App\Models\Task\TaskChannel;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Campaign
 *
 * @package App\Models
 * @property integer $id
 * @property integer $user_id
 * @property string $status // enum ['new', 'active', 'finished']
 * @property integer $version
 * @property string $title
 * @property Carbon $range_start_at
 * @property Carbon $range_end_at
 * @property integer $publication
 * @property integer $silence
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read CampaignContent $content
 * @property-read Task[] $tasks
 * @mixin Eloquent
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign wherePublication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereRangeEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereRangeStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereSilence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereVersion($value)
 * @method static CampaignQueryBuilder|Campaign byId()
 * @method static CampaignQueryBuilder|Campaign byRangeEndAt()
 * @method static CampaignQueryBuilder|Campaign byRangeStartAt()
 * @method static CampaignQueryBuilder|Campaign byTitle()
 * @method static CampaignQueryBuilder|Campaign filter()
 * @method static CampaignQueryBuilder|Campaign status($value)
 * @method static CampaignQueryBuilder|Campaign title($value)
 * @method static CampaignQueryBuilder|Campaign user_id($value)
 */
class Campaign extends Model
{
    use HasFactory;

    const STATUS_NEW = 'new';
    const STATUS_ACTIVE = 'active';
    const STATUS_FINISHED = 'finished';

    protected $guarded = [];

    protected $casts = [
        'range_start_at' => 'datetime',
        'range_end_at' => 'datetime',
        'publication' => 'integer',
        'silence' => 'integer',
        'version' => 'integer'
    ];

    protected $relations = ['task_channels'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->hasOne(CampaignContent::class)->withDefault();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function task_channels(): HasMany{
        return $this->hasMany(TaskChannel::class);
    }

    public function isNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isFinished()
    {
        return $this->status === self::STATUS_FINISHED;
    }

    public function timeCheck(): bool
    {
        $now = Carbon::now()->timestamp;
        $start = $this->range_start_at->timestamp;
        $end = $this->range_end_at->timestamp;

        return $start - $now >= config('telegator.campaign.hold_before_publication_start') &&
            $end - $start >= config('telegator.campaign.hold_between_publication_start_and_end');
    }

    public function ableToAssign(): bool
    {
        return $this->exists && $this->timeCheck() && $this->content->notEmpty();
    }

    //////////////////////////////////////////////////

    public function newEloquentBuilder($query): CampaignQueryBuilder
    {
        return new CampaignQueryBuilder($query);
    }

    public function campaigns(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->filter()->with($this->relations)->paginate(request('rows'));
    }

    public function updateOrCreateCampaign(StoreCampaignChannelRequest $request){

        $validated = $request->validated();

       $campaign = $this->updateOrCreate([
           'id' => request('id')
       ], $validated);

       foreach (request('tasks') as $task_id) {
           foreach (request('channels') as $channel_id) {
               TaskChannel::create([
                   'user_id' => auth()->id(),
                   'campaign_id' => $campaign->id,
                   'task_id' => $task_id,
                   'channel_id' => $channel_id,
               ]);
           }
       }

       return $campaign;

       //return $request->validated()['title'];// , 'user_id' => $request['user_id']
//        [
//            'title' => $validated['title'],
//            'user_id' => $validated['user_id'],
//            'description' => $validated['description'],
//            'range_start_at' => $validated['range_start_at'],
//            'range_end_at' => $validated['range_end_at'],
//        ]

    }

    public function campaignShow()
    {
        return $this->whereUserId(auth()->id())->whereId(request('id'))->first();
    }


    public function campaignDestroy()
    {
        return $this->whereUserId(auth()->id())->whereId(request('id'))->delete();
    }

    public function campaignUpdate()
    {
        return $this->whereUserId(auth()->id())->whereId(request('id'))->update(request()->all());
    }

    public function userCampaigns(){
        return $this->whereUserId(auth()->id())->where('range_end_at', '>=', Carbon::now()->toDateTimeString())->get();
    }


}
