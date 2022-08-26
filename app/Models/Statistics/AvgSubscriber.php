<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgSubscriber
 *
 * @property int $id
 * @property int $channel_id
 * @property int|null $total
 * @property string|null $day
 * @property string|null $week
 * @property string|null $month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgSubscriberFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSubscriber whereWeek($value)
 * @mixin \Eloquent
 */
class AvgSubscriber extends Model
{
    use HasFactory;
    protected $guarded = [];
}
