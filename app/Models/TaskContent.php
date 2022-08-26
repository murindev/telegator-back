<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TaskContent
 *
 * @package App\Models
 * @property integer   $task_id
 * @property string    $message
 * @property string    $message_raw
 * @property boolean   $with_video
 * @property boolean   $with_image
 * @property string    $link
 * @property integer   $created_at
 * @property integer   $updated_at
 * @property-read Task $task
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereMessageRaw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereWithImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskContent whereWithVideo($value)
 */
class TaskContent extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $incrementing = false;
    protected $primaryKey = 'task_id';

    protected $fillable = [
        'message',
        'message_raw',
        'with_video',
        'with_image',
        'link'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
