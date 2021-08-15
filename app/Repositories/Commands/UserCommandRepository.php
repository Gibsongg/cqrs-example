<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Models\User;
use Throwable;

final class UserCommandRepository
{
    /**
     * @throws Throwable
     */
    public function registration(User $user): void
    {
        $user->saveOrFail();
    }

    /**
     * @throws Throwable
     */
    public function update(User $user): void
    {
        $user->saveOrFail();
    }

    public function hasUserById(string $userId): bool
    {
        //проверяем пользователя в модели для записи т.к. в модель чтения и записи может расходится.
        return User::query()->useWritePdo()->where('id', $userId)->exists();
    }
}
