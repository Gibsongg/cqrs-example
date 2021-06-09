<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

final class UserProfileRepository
{

    public function findUserProfileByIdOrNew(string $id): Builder|Profile
    {
        return Profile::query()->findOrNew($id);
    }

    /**
     * @throws Throwable
     */
    public function update(Profile $profile): Profile
    {
        $profile->saveOrFail();

        return $profile;
    }
}