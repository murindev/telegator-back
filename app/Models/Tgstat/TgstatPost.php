<?php

namespace App\Models\Tgstat;

use App\Filters\TgstatPostQueryBuilder;
use App\Models\Channel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Tgstat\TgstatPost
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPost query()
 * @mixin \Eloquent
 */
class TgstatPost extends Model
{
    use HasFactory;

    protected $casts = [
        'media_json' => 'object'
    ];

    public $relations = ['stat'];


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('date');
        });
    }


    public function newEloquentBuilder($query): TgstatPostQueryBuilder
    {
        return new TgstatPostQueryBuilder($query);
    }

    // relations

    public function stat(): HasOne
    {
        return $this->hasOne(TgstatPostsStat::class, 'post_id', 'post_id');
    }

    public function channel() : BelongsTo
    {
        return $this->belongsTo(TgstatCommonInfo::class);
    }

    public function channelStat() : BelongsTo
    {
        return $this->belongsTo(TgstatStat::class,'channel_id','channel_id');
    }

    public function views_by_hours() : HasMany
    {
        return $this->hasMany(TgstatPostsToViewsByHour::class, 'post_id', 'post_id');
    }

    public function  tgstat_post_stat(): HasOne
    {
        return $this->hasOne(TgstatPostsStat::class,'post_id','post_id');
    }


    // requests

    public function index()
    {
        return $this
            ->where('channel_id', request('channel_id'))
            ->with($this->relations)
            ->filter()
            ->paginate(request('rows'));
    }


    public function show($post_id)
    {
        return $this->where('post_id', $post_id)
            ->with(array_merge(['channelStat','views_by_hours'], $this->relations))->first();
    }


}
