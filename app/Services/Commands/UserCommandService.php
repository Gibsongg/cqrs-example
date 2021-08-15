<?php

declare(strict_types=1);

namespace App\Services\Commands;

use App\Dto\User\UserProfileDto;
use App\Models\User;
use App\Repositories\Commands\UserCommandRepository;
use App\Repositories\Commands\UserProfileCommandRepository;
use Throwable;

class UserCommandService
{
    protected UserCommandRepository $userRepository;
    protected UserProfileCommandRepository $profileRepository;

    public function __construct(UserCommandRepository $userRepository, UserProfileCommandRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }


    /**
     * @throws \Throwable
     */
    public function create(User $user): void
    {
        $this->userRepository->registration($user);
    }


    /**
     * Сохранение профиля
     *
     * @throws Throwable
     */
    public function editProfile(string $userId, UserProfileDto $profileDto): void
    {
        if (false === $this->userRepository->hasUserById($userId)) {
            throw new \RuntimeException('Нет такого пользователя');
        }

        $profile = $this->profileRepository->findUserProfileByIdOrNew($userId);

        $profile->user_id = $userId;

        if (!empty($profileDto->name)) {
            $profile->name = $profileDto->name;
        }

        if (!empty($profileDto->aboutMe)) {
            $profile->about_me = $profileDto->aboutMe;
        }

        if (!empty($profileDto->birthday)) {
            $profile->birthday = $profileDto->birthday;
        }

        $this->profileRepository->update($profile);
    }
}
