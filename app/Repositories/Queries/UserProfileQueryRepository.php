<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Profile;
use App\Repositories\QueryRepository;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

final class UserProfileQueryRepository extends QueryRepository
{

    public function findUserProfileByIdOrNew(string $id): Builder|Profile
    {
        return Profile::on($this->connection)->findOrNew($id);
    }

    /**
     * @throws Throwable
     */
    public function update(Profile $profile): Profile
    {
        $profile->on($this->connection)->saveOrFail();

        return $profile;
    }
}
