<?php

declare(strict_types=1);

namespace App\Post\Repositories;


use App\Post\Domain\Entities\Post;
use App\Post\Domain\Repositories\PostRepositoryInterface;
use Throwable;

/**
 * Репозиторий для комманд постов.
 * Нужен чтобы вынести работу с ORM за пределы доменного слоя.
 * Но если вызов хендлеров сделать через события, то команды можно оставить в домене а хендлеры вынести за домен
 */
final class PostRepository implements PostRepositoryInterface
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
    public function updatePost(Post $post): void
    {
        $post->exists = true;
        $post->saveOrFail();
    }

    /**
     * Удаление поста
     */
    public function destroy(string $id): void
    {
        Post::destroy($id);
    }
}
