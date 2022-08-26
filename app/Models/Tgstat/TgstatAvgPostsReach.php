<?php

namespace App\Models\Tgstat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tgstat\TgstatAvgPostsReach
 *
 * @method static \Database\Factories\Tgstat\TgstatAvgPostsReachFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatAvgPostsReach newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatAvgPostsReach newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatAvgPostsReach query()
 * @mixin \Eloquent
 */
class TgstatAvgPostsReach extends Model
{
    use HasFactory;

    protected $casts = [
        'avg_posts_reach_json' => 'object'
    ];
}
