<?php

declare(strict_types=1);

namespace App\Dictionaries;

class EventType
{
    public const EVENT_USER_CREATE = 'user_create';
    public const EVENT_USER_UPDATE = 'user_update';

    public const EVENT_POST_CREATE = 'post_create';
    public const EVENT_POST_UPDATE = 'post_update';
}
