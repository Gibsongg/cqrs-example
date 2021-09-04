<?php

declare(strict_types=1);

namespace App\User\Domain\Commands;

use Spatie\DataTransferObject\DataTransferObject;

final class RegistrationCommand extends DataTransferObject
{
    public string $id;

    public string $email;

    public string $password;

    public int $status;
}
