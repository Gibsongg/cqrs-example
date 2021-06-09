<?php

namespace App\Http\Controllers;

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

    private UserFollowService $followService;

    public function __construct()
    {
        $this->followService = app()->get(UserFollowService::class);
    }

    public function subscribe(string $userId): Response|Application|ResponseFactory
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            throw new \RuntimeException('Пользователь не найден');
        }

        $this->followService->subscribe($user, $userId);

        return response(['success' => true]);
    }

    public function unsubscribe(string $userId): Response|Application|ResponseFactory
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            throw new \RuntimeException('Пользователь не найден');
        }

        $this->followService->unsubscribe($user, $userId);

        return response(['success' => true]);
    }
}

