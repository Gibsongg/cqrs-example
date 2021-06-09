<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $id;
 * @property string $email;
 * @property Carbon $email_verified_at;
 * @property string $password;
 * @property string $remember_token;
 * @property int $status;
 * @property Carbon $created_at;
 * @property Carbon $updated_at;
 * @property-read User[] $followers
 * @property-read User[] $subscribers
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'followers', 'owner_id', 'follower_id', 'id', 'id');
    }

    public function subscribers(): BelongsToMany
    {

        return $this->belongsToMany(__CLASS__, 'followers', 'follower_id', 'owner_id', 'id', 'id');

    }
}
