<?php

declare(strict_types=1);

namespace App\Dto\Post;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * DTO поста
 *
 * @package App\Dto\Post
 */
class PostDto extends DataTransferObject
{
    public ?string $id;

    public ?string $user_id;

    public string $title;

    public string $message;
}