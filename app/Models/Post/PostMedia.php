<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post\PostMedia
 *
 * @property int $id
 * @property int $channel_id
 * @property int $post_id
 * @property string $media
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\Post\PostMediaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostMedia extends Model
{
    use HasFactory;
}
