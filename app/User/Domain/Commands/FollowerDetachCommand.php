<?php

declare(strict_types=1);

namespace App\User\Domain\Commands;

use Spatie\DataTransferObject\DataTransferObject;

final class FollowerDetachCommand extends DataTransferObject
{
    public string $userOwnerId;

    public string $userSubscribeId;
}
