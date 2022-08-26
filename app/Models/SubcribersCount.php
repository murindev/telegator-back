<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubcribersCount
 *
 * @property int $id
 * @property int $channel_id
 * @property int $count
 * @property int $delta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereDelta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubcribersCount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubcribersCount extends Model
{
    use HasFactory;

}
