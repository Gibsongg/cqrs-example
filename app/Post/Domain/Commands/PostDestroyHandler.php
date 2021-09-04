<?php

declare(strict_types=1);

namespace App\Post\Domain\Commands;

use App\Post\Domain\Entities\Post;
use App\Post\Domain\Repositories\PostRepositoryInterface;

class PostDestroyHandler
{
    private PostRepositoryInterface $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(PostDestroyCommand $command): void
    {
        $this->repository->destroy($command->id);
    }
}
