<?php

namespace App\Services\TelegramBot\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Class Room
 *
 * @package App\Services\TelegramBot\Models
 * @property int    $id
 * @property array  $data
 * @property int    $processed
 * @property int    $created_at
 * @property int    $updated_at
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Updates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Updates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Updates query()
 * @method static \Illuminate\Database\Eloquent\Builder|Updates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Updates whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Updates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Updates whereProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Updates whereUpdatedAt($value)
 */
class Updates extends Model
{
    protected $table      = 'tg_bot_updates';
    protected $fillable   = ['data', 'processed'];
    protected $attributes = ['processed' => 0];
    protected $casts      = [
        'data' => 'array',
    ];
}
