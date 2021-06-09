<?php

declare(strict_types=1);

namespace App\Dto\User;

class UserRegistrationDto
{
    public ?string $id;

    public string $email;

    public string $password;

    public ?int $status;
}