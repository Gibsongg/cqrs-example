<?php

declare(strict_types=1);

namespace App\User\Repositories;

use App\User\Domain\Repositories\UserFollowerRepositoryInterface;
use Illuminate\Support\Facades\DB;

final class UserFollowerRepository implements UserFollowerRepositoryInterface
{
    public function subscribe(string $userOwnerId, string $userSubscribeId): void
    {
        DB::table('followers')->insert(
            [
                'owner_id'    => $userOwnerId,
                'follower_id' => $userSubscribeId,
            ]
        );
    }

    public function unsubscribe(string $userOwnerId, string $userSubscribeId): void
    {
        DB::table('followers')->delete(
            [
                'owner_id'    => $userOwnerId,
                'follower_id' => $userSubscribeId,
            ]
        );
    }
}
