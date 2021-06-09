<?php

declare(strict_types=1);

namespace App\Factories\Users;

use App\Dictionaries\UserStatus;
use App\Dto\User\UserRegistrationDto;
use App\Http\Requests\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 * Статичная фабрика для редактирования пользователя
 *
 * @package App\Factories\Users
 */
class UserFactory
{
    public static function factory(UserProfile $dto, User $user): User
    {
        if (!empty($dto->password)) {
            $user->password = Hash::make($dto->password);
        }

        if (!empty($dto->status)) {
            $user->status = UserStatus::STATUS_ACTIVE;
        }

        if (!empty($dto->email)) {
            $user->email = $dto->email;
        }

        if (!empty($dto->status)) {
            $user->status = $dto->status;
        }

        return $user;
    }
}