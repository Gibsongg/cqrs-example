<?php

declare(strict_types=1);

namespace App\Dto\User;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * DTO для профиля пользователя
 *
 * @package App\Dto
 */
class UserProfileDto extends DataTransferObject
{
    public string $name;

    public ?Carbon $birthday;

    public ?string $aboutMe;
}