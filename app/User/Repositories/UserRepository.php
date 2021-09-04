<?php

declare(strict_types=1);

namespace App\User\Repositories;

use App\User\Domain\entities\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Throwable;

final class UserRepository implements UserRepositoryInterface
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

    /**
     * Здесь мы допускаем возвращение данных, но не данные сущности, а простые типы.
     * Стоит так же отметить, что запрос следует делать в базу данных мастера т.к.
     * только там мы можем гарантировать консистентность данных.
     */
    public function hasUserById(string $userId): bool
    {
        return User::query()->useWritePdo()->where('id', $userId)->exists();
    }
}
