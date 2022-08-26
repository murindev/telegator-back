<?php

namespace App\Models\Tgstat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tgstat\TgstatView
 *
 * @method static \Database\Factories\Tgstat\TgstatViewFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatView query()
 * @mixin \Eloquent
 */
class TgstatView extends Model
{
    use HasFactory;

    protected $casts = [
        'avg_views' => 'object'
    ];
}
