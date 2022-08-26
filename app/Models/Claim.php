<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Claim
 *
 * @package App\Models
 * @property integer $user_id
 * @property integer $channel_id
 * @property float   $price
 * @property string  $contacts
 * @property string  $link
 * @property array   $cat_ids
 * @property boolean $result
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Claim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim query()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereCatIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereContacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereUserId($value)
 * @mixin \Eloquent
 */
class Claim extends Model
{
    use HasFactory;

    protected $casts = [
        'cat_ids' => 'array',
        'result'  => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'channel_id',
        'price',
        'contacts',
        'link',
        'cat_ids',
        'result',
    ];
}
