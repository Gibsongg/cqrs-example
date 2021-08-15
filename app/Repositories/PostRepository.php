<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\Post\PostDto;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

final class PostRepository
{

    public function getPostsList(string $userId): Collection|array
    {
        return Post::query()
            ->whereHas('users', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
    }

    public function getById(string $id): Builder|Model|Post
    {
        return Post::query()->first($id);
    }

    /**
     * Создание нового поста
     *
     * @throws Throwable
     */
    public function createPost(PostDto $postDto): Post
    {
        $post = new Post();
        $post->id = $postDto->id;
        $post->user_id = $postDto->user_id;
        $post->title = $postDto->title;
        $post->message = $postDto->message;
        $post->saveOrFail();

        return $post;
    }

    /**
     * Обновление поста
     *
     * @throws \Throwable
     */
    public function updatePost(string $id, PostDto $postDto): Post
    {
        /** @var Post $post */
        $post = Post::query()->findOrFail($id);

        $post->title = $postDto->title;
        $post->message = $postDto->message;

        $post->saveOrFail();

        return $post;
    }

    /**
     * Удаление поста
     */
    public function delete(string $id): int
    {
        return Post::destroy($id);
    }
}
