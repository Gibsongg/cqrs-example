<?php

namespace App\Http\Controllers;

use App\Services\Commands\UserFollowCommandService;
use App\Services\UserFollowService;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 *
 * @package App\Http\Controllers
 */
final class UserFollowController extends Controller
{

    private UserFollowCommandService $followCommandService;

    public function __construct()
    {
        $this->followCommandService = app()->get(UserFollowCommandService::class);
    }

    /**
     * @throws \Throwable
     */
    public function subscribe(string $userId): Response|Application|ResponseFactory
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            throw new \RuntimeException('Пользователь не найден');
        }

        $this->followCommandService->subscribe($user, $userId);

        return response(['success' => true]);
    }

    /**
     * @throws \Throwable
     */
    public function unsubscribe(string $userId): Response|Application|ResponseFactory
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            throw new \RuntimeException('Пользователь не найден');
        }

        $this->followCommandService->unsubscribe($user, $userId);

        return response(['success' => true]);
    }
}

