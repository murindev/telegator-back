<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Eloquent;

/**
 * Class ChannelData
 *
 * @package App\Models
 * @property integer $channel_id
 * @property integer $members
 * @property integer $last_post_id
 * @property integer $avg_post_reach
 * @property integer $avg_daily_reach
 * @property integer $avg_posts_per_day
 * @mixin Eloquent
 * @property-read \App\Models\Channel|null $channel
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChannelData query()
 */
class ChannelData extends Model
{
    use HasFactory;

    public    $incrementing = false;
    protected $primaryKey   = 'channel_id';

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
