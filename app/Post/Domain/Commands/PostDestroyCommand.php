<?php

declare(strict_types=1);

namespace App\Post\Domain\Commands;

use Spatie\DataTransferObject\DataTransferObject;

class PostDestroyCommand extends DataTransferObject
{
    public string $id;
}
