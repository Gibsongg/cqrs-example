<?php

declare(strict_types=1);

namespace App\User\Domain\Commands;

use App\User\Domain\Repositories\UserRepositoryInterface;

class HasUserByIdHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Здесь мы допускаем возвращение данных, но не данные сущности, а простые типы.
     * Стоит так же отметить, что запрос следует делать в базу данных мастера т.к.
     * только там мы можем гарантировать консистентность данных.
     */
    public function execute(string $userId): bool
    {
        return $this->repository->hasUserById($userId);
    }
}
