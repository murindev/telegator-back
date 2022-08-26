<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Task\TaskMedia
 *
 * @method static \Database\Factories\Task\TaskMediaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskMedia query()
 * @mixin \Eloquent
 */
class TaskMedia extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function saveMedia($taskId)
    {

        try {
            foreach (\request('image') as $key => $image) {

                if ($image_64 = $image) {
                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];

                    $data = substr($image_64, strpos($image_64, ',') + 1);
                    $data = base64_decode($data);
                    $path = 'public/task/media/' . $taskId . '_'. $key . '.' . $extension;
                    $filename = '/storage/task/media/' . $taskId . '_' . $key . '.' . $extension;
                    \Storage::put($path, $data);
                    TaskMedia::create(['task_id' => $taskId, 'type' => 'image', 'src' => $filename]);
                }
            }

        } catch (\Exception $e) {
            return $e;
        }
    }
}
