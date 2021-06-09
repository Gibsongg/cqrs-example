<?php

declare(strict_types=1);

namespace App\Services;

use App\Dictionaries\UserStatus;
use App\Dto\Post\PostDto;
use App\Jobs\PostFollowersJob;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Throwable;

final class PostService
{

    protected PostRepository $postRepository;
    protected UserRepository $userRepository;

    public function __construct(PostRepository $postRepository, UserRepository $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
    }

    public function postsList()
    {
        return $this->postRepository->getPostsList((string)Auth::id());
    }

    /**
     * Создание сообщения
     *
     * @throws Throwable
     */
    public function create(PostDto $postDto): Post
    {
        $postDto->id = $postDto->id ?? Uuid::uuid4()->toString();
        $user = $this->userRepository->findUserByIdOrFail($postDto->user_id);

        if (empty($postDto->title)) {
            throw new \RuntimeException('Заголовок не задан');
        }

        if (null === $user) {
            throw new \RuntimeException('Пользователь не найден');
        }

        DB::beginTransaction();

        try {
            $post = $this->postRepository->createPost($postDto);
            $post->users()->attach($user->id);
            foreach ($user->subscribers as $subscriber) {
                $post->users()->attach($subscriber->id);
            }
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        DB::commit();
        return $post;
    }

    /**
     * Обновление поста
     * @throws \Throwable
     */
    public function update(string $id, PostDto $postDto): Post
    {
        if (empty($postDto->title)) {
            throw new \RuntimeException('Заголовок не задан');
        }

        return $this->postRepository->updatePost($id, $postDto);
    }

    /**
     * Удаление поста
     */
    public function delete(string $postId): int
    {
        return $this->postRepository->delete($postId);
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
