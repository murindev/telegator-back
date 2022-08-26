<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\PostCount
 *
 * @property int $id
 * @property int $channel_id
 * @property int|null $total
 * @property int|null $day
 * @property int|null $week
 * @property int|null $month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\PostCountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostCount whereWeek($value)
 * @mixin \Eloquent
 */
class AvgPostCount extends Model
{
    use HasFactory;
    protected $guarded = [];
}
