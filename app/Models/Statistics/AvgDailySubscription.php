<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgDailySubscription
 *
 * @property int $id
 * @property int $channel_id
 * @property string|null $total
 * @property string|null $plus
 * @property string|null $minus
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgDailySubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereMinus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription wherePlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgDailySubscription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvgDailySubscription extends Model
{
    use HasFactory;
    protected $guarded = [];
}
