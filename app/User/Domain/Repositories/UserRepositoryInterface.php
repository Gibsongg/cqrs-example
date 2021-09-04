<?php

declare(strict_types=1);

namespace App\User\Domain\Repositories;

use App\User\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function registration(User $user): void;

    public function update(User $user): void;

    public function hasUserById(string $userId): bool;
}
