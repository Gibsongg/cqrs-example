<?php

declare(strict_types=1);

namespace App\Factories\Users;

use App\Dto\Post\PostDto;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

/**
 * Статичная фабрика для создания поста
 *
 * @package App\Factories\Users
 */
class PostCreateFactory
{
    public static function factory(PostDto $dto): Post
    {
        $post = new Post();
        $post->id = Uuid::uuid4()->toString();
        $post->user_id = Auth::id();
        $post->title = $dto->title;
        $post->message = $dto->message;

        return $post;
    }
}
