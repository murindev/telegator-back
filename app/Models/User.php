<?php

namespace App\Models;

use App\Utils\Generator;
use Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @package App\Models
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $email_verified_at
 * @property string $avatar
 * @property string $api_token
 * @property integer $created_at
 * @property integer $updated_at
 * @property-read string $real_email
 * @property-read TelegramUser $telegram
 * @mixin Eloquent
 * @property string $balance
 * @property string $hold
 * @property string $password
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Campaign[] $campaign
 * @property-read int|null $campaign_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read bool $is_telegram_connected
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'real_email',
        'is_telegram_connected'
    ];

    public function campaign()
    {
        return $this->hasMany(Campaign::class);
    }

    public function telegram()
    {
        return $this->hasOne(TelegramUser::class);
    }

    public function getRealEmailAttribute(): ?string
    {
        return Str::endsWith($this->email, Generator::EMAIL_POSTFIX) ? null : $this->email;
    }

    public function getIsTelegramConnectedAttribute(): bool
    {
        return $this->telegram ? true : false;
    }

    public function createUser(string $email, string $password, string $name = null)
    {
        $this->name = $name ?: $email;
        $this->email = $email;
        $this->password = Hash::make($password);
        $this->save();
        return $this;
    }


    public function balanceUpdate($holdSum)
    {
        $this->hold = $this->hold + $holdSum;
        $this->balance = $this->balance - $holdSum;
        $this->save();
        return $this;

    }
}
