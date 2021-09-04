<?php

declare(strict_types=1);

namespace App\Post\Domain\Commands;

use Spatie\DataTransferObject\DataTransferObject;

class PostUpdateCommand extends DataTransferObject
{
    public string $id;

    public string $title;

    public string $message;
}
