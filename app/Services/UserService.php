<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\User\UserProfileDto;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use Throwable;

class UserService
{
    protected UserRepository $userRepository;
    protected UserProfileRepository $profileRepository;

    public function __construct(UserRepository $userRepository, UserProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }


    /**
     * @throws \Throwable
     */
    public function create(User $user): User
    {
        return $this->userRepository->registration($user);
    }


    /**
     * Сохранение профиля
     *
     * @throws Throwable
     */
    public function editProfile(string $userId, UserProfileDto $profileDto): Profile
    {
        $this->userRepository->findUserByIdOrFail($userId);

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

        return $this->profileRepository->update($profile);
    }
}
