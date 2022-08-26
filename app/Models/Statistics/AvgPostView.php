<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgPostView
 *
 * @property int $id
 * @property int $channel_id
 * @property int|null $total
 * @property string|null $err
 * @property string|null $err_daily
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgPostViewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereErr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereErrDaily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgPostView whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvgPostView extends Model
{
    use HasFactory;
    protected $guarded = [];
}
