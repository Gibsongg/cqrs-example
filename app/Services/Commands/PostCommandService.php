<?php

declare(strict_types=1);

namespace App\Services\Commands;

use App\Dictionaries\UserStatus;
use App\Dto\Post\PostDto;
use App\Jobs\PostFollowersJob;
use App\Models\Post;
use App\Models\User;
use App\Repositories\Commands\PostCommandRepository;
use App\Repositories\Commands\UserCommandRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Throwable;

final class PostCommandService
{

    protected PostCommandRepository $postRepository;
    protected UserCommandRepository $userRepository;

    public function __construct(PostCommandRepository $postRepository, UserCommandRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Создание сообщения
     *
     * @throws Throwable
     */
    public function create(Post $post): void
    {
        if (empty($post->title)) {
            throw new \RuntimeException('Заголовок не задан');
        }

        if (false === $this->userRepository->hasUserById($post->user_id)) {
            throw new \RuntimeException('Пользователь не найден');
        }

        DB::beginTransaction();

        try {
            $this->postRepository->createPost($post);
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        DB::commit();
    }

    /**
     * Обновление поста
     * @throws \Throwable
     */
    public function update(string $id, PostDto $postDto): void
    {
        if (empty($postDto->title)) {
            throw new \RuntimeException('Заголовок не задан');
        }

        $this->postRepository->updatePost($id, $postDto);
    }

    /**
     * Удаление поста
     */
    public function delete(string $postId): void
    {
        $this->postRepository->delete($postId);
    }

    /**
     * Добавление статьи фолловерам
     */
    public function pushFollowers(Post $post): void
    {
        /** @var User $user */
        $user = User::query()->find($post->user_id);
        $user->followers()->where('status', UserStatus::STATUS_ACTIVE)->chunk(
            500,
            static function ($users) use ($post) {
                foreach ($users as $user) {
                    $post->followers()->attach($user->id);
                }
            }
        );
    }
}
