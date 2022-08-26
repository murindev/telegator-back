<?php

namespace App\Models\Task;

use App\Http\Requests\StoreTaskPriceRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Task\TaskPrice
 *
 * @method static \Database\Factories\Task\TaskPriceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $channel_id
 * @property int $post_price_type_id
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice wherePostPriceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskPrice whereUpdatedAt($value)
 */
class TaskPrice extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function updateOrCreatePrices(Task $task, StoreTaskPriceRequest $request)
    {

        foreach ($request->validated()['prices'] as $price) {
            TaskPrice::updateOrCreate(
                ['task_id' => $task->id, 'post_price_type_id' => $price['post_price_type_id']],
                ['price' => $price['price']]
            );
        }

    }
}
