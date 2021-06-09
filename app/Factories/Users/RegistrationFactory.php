<?php

declare(strict_types=1);

namespace App\Factories\Users;

use App\Dictionaries\UserStatus;
use App\Dto\User\UserRegistrationDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 * Статичная фабрика для создания пользователя при регистрации
 *
 * @package App\Factories\Users
 */
class RegistrationFactory
{
    public static function factory(string $email, string $password): User
    {
        $user = new User();
        $user->id = Uuid::uuid4()->toString();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->status = UserStatus::STATUS_ACTIVE;

        return $user;
    }
}
