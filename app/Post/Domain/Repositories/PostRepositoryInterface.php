<?php

declare(strict_types=1);

namespace App\Post\Domain\Repositories;

use App\Post\Domain\Entities\Post;

interface PostRepositoryInterface
{
    public function createPost(Post $post): void;

    public function updatePost(Post $post): void;

    public function destroy(string $id): void;
}
