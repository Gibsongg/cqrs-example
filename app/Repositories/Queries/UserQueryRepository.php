<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\User;
use App\Repositories\QueryRepository;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

final class UserQueryRepository extends QueryRepository
{
    public function findUserByIdOrFail(string $id): Builder|User|null
    {
        return User::query()->findOrFail($id);
    }
}
