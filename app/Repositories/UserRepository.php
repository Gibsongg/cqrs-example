<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

final class UserRepository
{


    public function findUserByIdOrFail(string $id): Builder|User|null
    {
        return User::query()->findOrFail($id);
    }

    /**
     * @throws Throwable
     */
    public function registration(User $user): User
    {
        $user->saveOrFail();

        return $user;
    }

    /**
     * @throws Throwable
     */
    public function update(User $user): User
   {
       $user->saveOrFail();

       return $user;
   }
}