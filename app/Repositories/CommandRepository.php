<?php

declare(strict_types=1);

namespace App\Repositories;

abstract class CommandRepository
{
    //в абстрактые классы можно вынести соединения и использовать ->connection($this->connection)
    protected string $connection = 'mysql:master';
}
