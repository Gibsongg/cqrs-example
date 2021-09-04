<?php

declare(strict_types=1);

namespace App\User\Domain\Repositories;

use App\User\Domain\Entities\User;

interface ProfileRepositoryInterface
{
    public function update(User $user): void;
}
