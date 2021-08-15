<?php

declare(strict_types=1);

namespace App\Services\Queries;

use App\Repositories\Queries\PostQueryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class PostQueryService
{

    protected PostQueryRepository $postRepository;

    public function __construct(PostQueryRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function postsList(): \Illuminate\Support\Collection
    {
        return $this->postRepository->getPostsList((string)Auth::id());
    }
}
