<?php

declare(strict_types=1);

namespace App\Post\Domain\Commands;

use App\Post\Domain\Entities\Post;
use App\Post\Domain\Repositories\PostRepositoryInterface;

class PostCreateHandler
{
    private PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PostCreateCommand $command): void
    {
        $entity = new Post(
            [
                'id' => $command->id,
                'title' => $command->title,
                'user_id' => $command->user_id,
                'message' => $command->message
            ]
        );

        $this->repository->createPost($entity);
    }
}
