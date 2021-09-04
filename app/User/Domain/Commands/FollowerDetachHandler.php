<?php

declare(strict_types=1);

namespace App\User\Domain\Commands;

use App\User\Domain\Repositories\UserFollowerRepositoryInterface;

class FollowerDetachHandler
{
    private UserFollowerRepositoryInterface $repository;

    public function __construct(UserFollowerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(FollowerDetachCommand $command): void
    {
        /**
         * Здесь чтобы сделать связь через модель ее нужно восстановить сделал запрос на чтение
         * Но во первых несколько нарушает принцип т.к. мы делаем запрос из команды.
         * По этому сделаем запрос в репозитории нативно через insert
         */
        $this->repository->subscribe($command->userOwnerId, $command->userSubscribeId);
    }
}
