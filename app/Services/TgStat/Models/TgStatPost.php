<?php

namespace App\Services\TgStat\Models;

use App\Models\Channel;
use App\Services\TgStat\TgStatService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TgStatsPost
 *
 * @package App\Models
 * @property integer $channel_id
 * @property integer $post_id
 * @property string  $text
 * @property string  $stat_link
 * @property boolean $with_video
 * @property boolean $with_image
 * @property integer $parsed_at
 * @property string  $parsed_dt_string
 * @property integer            $views
 * @property string             $views_raw
 * @property integer            $reposts
 * @property string             $reposts_raw
 * @property integer            $created_at
 * @property integer            $updated_at
 * @property-read string        $stat_url
 * @property-read string        $url
 * @property-read TgStatChannel $tg_stat_channel
 * @property-read Channel       $channel
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereParsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereParsedDtString($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereReposts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereRepostsRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereStatLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereViewsRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereWithImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TgStatPost whereWithVideo($value)
 */
class TgStatPost extends Model
{
    use HasFactory;
    public    $incrementing = false;
    protected $primaryKey   = ['channel_id', 'post_id'];

    protected $fillable = [
        'text',
        'stat_link',
        'with_video',
        'with_image',
        'parsed_at',
        'parsed_dt_string',
        'views',
        'views_raw',
        'reposts',
        'reposts_raw',
    ];

    protected $appends = [
        'stat_url',
        'url'
    ];

    public function tg_stat_channel()
    {
        return $this->belongsTo(TgStatChannel::class, 'channel_id', 'channel_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getStatUrlAttribute()
    {
        return TgStatService::getPostStatUrl($this->tg_stat_channel->slug, $this->post_id);
    }

    public function getUrlAttribute()
    {
        return TgStatService::getPostUrl($this->tg_stat_channel->slug, $this->post_id);
    }
}
