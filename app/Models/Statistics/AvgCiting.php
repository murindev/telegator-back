<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgCiting
 *
 * @property int $id
 * @property int $channel_id
 * @property string|null $total
 * @property string|null $channel_mentions
 * @property string|null $mentions
 * @property string|null $reposts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgCitingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereChannelMentions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereMentions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereReposts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgCiting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvgCiting extends Model
{
    use HasFactory;
    protected $guarded = [];
}
