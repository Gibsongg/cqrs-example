<?php

declare(strict_types=1);

namespace App\Post\Domain\Commands;

use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class PostCreateCommand extends DataTransferObject
{
    public string $id;

    public ?string $user_id;

    public string $title;

    public string $message;
}
