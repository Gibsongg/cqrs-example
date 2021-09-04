<?php

declare(strict_types=1);

namespace App\User\Domain\Commands;

use App\User\Domain\Entities\User;
use App\User\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class RegistrationHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RegistrationCommand $command): void
    {
        $entity = new User(
            [
                'id' => $command->id,
                'email' => $command->email,
                'password' => Hash::make($command->password),
                'status' => $command->status
            ]
        );

        $this->repository->registration($entity);
    }
}
