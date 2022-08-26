<?php

namespace App\Models\Tgstat;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tgstat\TgstatSubscriber
 *
 * @method static \Database\Factories\Tgstat\TgstatSubscriberFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatSubscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatSubscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TgstatSubscriber query()
 * @mixin \Eloquent
 */
class TgstatSubscriber extends Model
{
    use HasFactory;

    protected $casts = [
        'subscribers_json' => 'object'
    ];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }
}
