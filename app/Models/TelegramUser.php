<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TelegramUser
 *
 * @package App\Models
 * @property integer $id
 * @property integer $user_id
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $username
 * @property boolean $have_photo
 * @property-read User $user
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereHavePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUser whereUsername($value)
 */
class TelegramUser extends Model
{
    use HasFactory;

    public    $incrementing = false;
    protected $primaryKey   = 'id';

    public $fillable = [
        'first_name',
        'last_name',
        'username'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
