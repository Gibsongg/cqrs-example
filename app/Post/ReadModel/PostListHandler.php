<?php

declare(strict_types=1);

namespace App\Post\ReadModel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PostListHandler
{
    public function execute(PostListQuery $query): Collection
    {
        return DB::table('posts')
            ->join('users_posts', 'post_id', '=', 'id')
            ->where('users_posts.user_id', $query->userId)
            ->limit($query->limit)
            ->get();
    }
}
