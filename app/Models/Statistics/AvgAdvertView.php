<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgAdvertView
 *
 * @property int $id
 * @property int $channel_id
 * @property int|null $total
 * @property string|null $half_day
 * @property string|null $day
 * @property string|null $two_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgAdvertViewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereHalfDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereTwoDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgAdvertView whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvgAdvertView extends Model
{
    use HasFactory;
    protected $guarded = [];
}
