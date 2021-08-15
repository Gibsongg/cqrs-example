<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Dto\Post\PostDto;
use App\Models\Post;
use App\Repositories\CommandRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

final class PostCommandRepository extends CommandRepository
{
    /**
     * Создание нового поста
     *
     * @throws Throwable
     */
    public function createPost(Post $post): void
    {
        $post->saveOrFail();

        $post->users()->attach($post->user_id);
        $subscribers = $post->user->subscribers()->pluck('id');

        foreach ($subscribers as $subscriber)
        {
            $post->users()->attach($subscriber);
        }
    }

    /**
     * Обновление поста
     *
     * @throws \Throwable
     */
    public function updatePost(string $id, PostDto $postDto): void
    {
        /** @var Post $post */
        $post = Post::query()->findOrFail($id);

        $post->title = $postDto->title;
        $post->message = $postDto->message;

        $post->saveOrFail();
    }

    /**
     * Удаление поста
     */
    public function delete(string $id): void
    {
        Post::destroy($id);
    }
}
