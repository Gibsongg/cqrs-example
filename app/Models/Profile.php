<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $user_id;
 * @property string $name;
 * @property Carbon $birthday;
 * @property string $about_me;
 * @package App\Models
 */
class Profile extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $primaryKey = 'user_id';
}
