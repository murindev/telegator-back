<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post\PostView
 *
 * @property int $id
 * @property int $channel_id id канала tgator
 * @property int $post_id id поста tgator
 * @property int|null $post_nr Номер поста в тг
 * @property int $hour Номер часа от 1 до 24
 * @property string $percentage
 * @property int $views_cnt
 * @property string|null $tg_stat_created_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Post\PostViewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView wherePostNr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereTgStatCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostView whereViewsCnt($value)
 * @mixin \Eloquent
 */
class PostView extends Model
{
    use HasFactory;
}
