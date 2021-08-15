<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class PostQueryRepository
{
    public function getPostsList(string $userId): Collection
    {
        return DB::table('posts')
            ->join('users_posts', 'post_id', '=', 'id')
            //->joinWhere()
            ->where('users_posts.user_id', $userId)
            ->limit(100)
            ->get();
    }

    public function getById(string $id): Builder|Model|Post
    {
        return Post::query()->first($id);
    }
}
