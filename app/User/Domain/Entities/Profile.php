<?php

namespace App\User\Domain\Entities;

/**
 * Value-Object профиля пользователя
 *
 * @package App\User\Domain\Entities
 */
class Profile
{
    protected string $name;

    protected string $birthday;

    protected string $about_me;

    protected string $status;

    /**
     * Profile constructor.
     *
     * @param string $name
     * @param string $birthday
     * @param string $about_me
     * @param string $status
     */
    public function __construct(string $name, string $birthday, string $about_me, string $status)
    {
        $this->name = $name;
        $this->birthday = $birthday;
        $this->about_me = $about_me;
        $this->status = $status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getAboutMe(): string
    {
        return $this->about_me;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
