<?php

namespace App\Http\Controllers;

use App\Dto\User\UserProfileDto;
use App\Factories\Users\RegistrationFactory;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserProfile;
use App\Http\Requests\UserRegistration;
use App\Services\Commands\UserCommandService;
use App\Models\User;
use RuntimeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserController extends Controller
{
    private UserCommandService $userCommandService;

    public function __construct()
    {
        $this->userCommandService = app()->get(UserCommandService::class);
    }

    /**
     * Регистрация пользователя
     * @throws \Throwable
     */
    public function registration(UserRegistration $request): Response
    {
        $factory = RegistrationFactory::factory($request->input('email'), $request->input('password'));
        $this->userCommandService->create($factory);

        return response(['success' => true, 'id' => $factory->id]);
    }

    /**
     * Получение токена аунтентификации
     */
    public function login(UserLogin $request): Response
    {
        /** @var User $user */
        //Если используется запрос где нужно получить актуальные данные читаем из таблицы записи useWritePdo()
        $user = User::query()->useWritePdo()->where('email', $request->input('email'))->firstOrFail();
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
        $this->userCommandService->editProfile($id, $userProfile);

        return response(['success' => true]);
    }
}

