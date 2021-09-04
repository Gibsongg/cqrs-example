<?php

namespace App\User\Http\Controllers;

use App\Dictionaries\UserStatus;
use App\Http\Controllers\Controller;
use App\User\Domain\Commands\RegistrationCommand;
use App\User\Domain\Commands\RegistrationHandler;
use App\User\Domain\Entities\User;
use App\User\Http\Requests\UserLogin;
use App\User\Http\Requests\UserRegistration;
use Illuminate\Support\Str;
use RuntimeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class UserController extends Controller
{
    public RegistrationHandler $registrationHandler;

    public function __construct()
    {
        $this->registrationHandler = app()->get(RegistrationHandler::class);
    }

    /**
     * Регистрация пользователя
     * @throws \Throwable
     */
    public function registration(UserRegistration $request): Response
    {
        $command = new RegistrationCommand(
            id:       Str::uuid()->toString(),
            email:    $request->input('email'),
            password: $request->input('password'),
            status:   UserStatus::STATUS_ACTIVE
        );

        $this->registrationHandler->execute($command);

        return response(['success' => true, 'id' => $command->id]);
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
}

