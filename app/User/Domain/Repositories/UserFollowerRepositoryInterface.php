<?php

declare(strict_types=1);

namespace App\User\Domain\Repositories;

interface UserFollowerRepositoryInterface
{
    public function subscribe(string $userOwnerId, string $userSubscribeId): void;

    public function unsubscribe(string $userOwnerId, string $userSubscribeId): void;
}
