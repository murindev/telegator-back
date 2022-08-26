<?php

namespace App\Models\Tgstat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tgstat\TgstatPostsStat
 *
 * @method static \Database\Factories\Tgstat\TgstatPostsStatFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPostsStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPostsStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatPostsStat query()
 * @mixin \Eloquent
 */
class TgstatPostsStat extends Model
{
    use HasFactory;

    protected $casts = [
        'forward_json' => 'object',
        'mentions_json' => 'object'
    ];
}
