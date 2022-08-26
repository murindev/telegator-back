<?php

namespace App\Services\TgStat\Models;

use App\Models\Channel;
use App\Services\TgStat\TgStatService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TgStatsChannel
 *
 * @package App\Models
 * @property integer $channel_id
 * @property boolean $status
 * @property string  $avatar
 * @property string  $title
 * @property string  $description
 * @property integer $members
 * @property integer $last_post_id
 * @property integer $avg_post_reach
 * @property string  $avg_post_reach_raw
 * @property integer $avg_daily_reach
 * @property string  $avg_daily_reach_raw
 * @property integer $avg_posts_per_day
 * @property string  $avg_posts_per_day_raw
 * @property float   $err_percent
 * @property string  $err_percent_raw
 * @property float   $citation_index
 * @property string  $citation_index_raw
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string  $slug
 * @property-read string  $url
 * @property-read Channel $channel
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgDailyReach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgDailyReachRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgPostReach($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgPostReachRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgPostsPerDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereAvgPostsPerDayRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereCitationIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereCitationIndexRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereErrPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereErrPercentRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereLastPostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatChannel whereUpdatedAt($value)
 */
class TgStatChannel extends Model
{
    use HasFactory;

    public    $incrementing = false;
    protected $primaryKey   = 'channel_id';

    protected $fillable = [
        'status',
        'avatar',
        'title',
        'description',
        'members',
        'last_post_id',
        'avg_post_reach',
        'avg_post_reach_raw',
        'avg_daily_reach',
        'avg_daily_reach_raw',
        'avg_posts_per_day',
        'avg_posts_per_day_raw',
        'err_percent',
        'err_percent_raw',
        'citation_index',
        'citation_index_raw',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getSlugAttribute()
    {
        return TgStatService::getChannelSlug($this->channel->slug, $this->channel->is_public);
    }

    public function getUrlAttribute()
    {
        return TgStatService::getChannelUrl($this->slug);
    }
}
