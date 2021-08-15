<?php

declare(strict_types=1);

namespace App\Services\Commands;

use App\Dictionaries\UserStatus;
use App\Dto\User\UserProfileDto;
use App\Dto\UserRegistrationDto;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Ramsey\Uuid\Nonstandard\Uuid;
use Throwable;

class UserFollowCommandService
{
    /**
     * Подписка и отписка на пользователей
     *
     * @throws Throwable
     */
    public function subscribe(User $user, string $follower): void
    {
        $follower = User::query()->findOrFail($follower);

        $user->followers()->sync($follower);

        if (!$follower->saveOrFail()) {
            throw new RuntimeException('Ошибка регистрации пользователя');
        }
    }

    /**
     * Сохранение профиля
     *
     * @throws Throwable
     */
    public function unsubscribe(User $user, string $follower): void
    {
        $follower = User::query()->findOrFail($follower);

        $user->followers()->detach($follower);

        if (!$follower->saveOrFail()) {
            throw new RuntimeException('Ошибка регистрации пользователя');
        }
    }
}
