<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * Class Transaction
 *
 * @package App\Models
 * @property integer $id
 * @property string  $type
 * @property integer $source_id
 * @property string  $source_type
 * @property integer $destination_id
 * @property string  $destination_type
 * @property float   $value
 * @property array   $reason
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDestinationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDestinationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereValue($value)
 */
class Transaction extends Model
{
    use HasFactory;

    const DEPOSIT_TYPE  = 'deposit';
    const WITHDRAW_TYPE = 'withdraw';
    const TRANSFER_TYPE = 'transfer';

    protected $casts = [
        'reason' => 'array'
    ];
}
