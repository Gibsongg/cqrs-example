<?php

declare(strict_types=1);

namespace App\Post\ReadModel;

class PostListQuery
{
    public string $userId;
    public int $limit = 100;
}
