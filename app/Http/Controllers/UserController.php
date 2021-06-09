<?php

namespace App\Http\Controllers;

use App\Dto\User\UserProfileDto;
use App\Factories\Users\RegistrationFactory;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserProfile;
use App\Http\Requests\UserRegistration;
use App\Services\UserService;
use App\Models\User;
use App\Repositories\UserRepository;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserController extends Controller
{
    private UserService $userService;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userService = app()->get(UserService::class);
        $this->userRepository = app()->get(UserRepository::class);
    }

    /**
     * Регистрация пользователя
     * @throws \Throwable
     */
    public function registration(UserRegistration $request): Response
    {
        $factory = RegistrationFactory::factory($request->input('email'), $request->input('password'));
        $this->userService->create($factory);

        return response(['success' => true, 'id' => $factory->id]);
    }

    /**
     * Получение токена аунтентификации
     */
    public function login(UserLogin $request): Response
    {
        /** @var User $user */
        $user = User::query()->where('email', $request->input('email'))->firstOrFail();
        if (!Hash::check($request->input('password'), $user->password)) {
            throw new RuntimeException('Логин и пароль не равны');
        }

        Auth::setUser($user);
        $token = $request->user()->createToken($user->id);

        return response(['token' => $token]);
    }

    /**
     * Редактирование профиля
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Throwable
     */
    public function editProfile(string $id, UserProfile $request): Response
    {
        $userProfile = new UserProfileDto($request->toArray());
        $this->userService->editProfile($id, $userProfile);
        return response(['success' => true]);
    }
}

