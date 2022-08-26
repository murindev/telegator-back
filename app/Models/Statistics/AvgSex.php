<?php

namespace App\Models\Statistics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistics\AvgSex
 *
 * @property int $id
 * @property int $channel_id
 * @property string|null $male
 * @property string|null $female
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Statistics\AvgSexFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex query()
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereFemale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereMale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AvgSex whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AvgSex extends Model
{
    use HasFactory;
    protected $guarded = [];
}
