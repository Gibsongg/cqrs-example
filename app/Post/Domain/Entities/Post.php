<?php

namespace App\Post\Domain\Entities;

use App\User\Domain\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $user_id
 * @property string $title
 * @property string $message
 * @property-read User $user;
 *
 * @package App\Models
 */
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'message',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $hidden = ['deleted_at'];

    public static function instantiate(string $id, string $userId, string $title, string $message): self
    {
        return new self(
            [
                'id' => $id,
                'user_id' => $userId,
                'title' => $title,
                'message' => $message
            ]
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_posts');
    }
}
