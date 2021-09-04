<?php

namespace App\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User\Domain\Commands\FollowerDetachCommand;
use App\User\Domain\Commands\FollowerDetachHandler;
use App\User\Domain\Entities\User;
use App\User\Domain\Commands\FollowerAttachCommand;
use App\User\Domain\Commands\FollowerAttachHandler;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RuntimeException;


/**
 *
 * @package App\Http\Controllers
 */
final class UserFollowController extends Controller
{
    private FollowerAttachHandler $followerAttachHandler;
    private FollowerDetachHandler $followerDetachHandler;

    public function __construct()
    {
        $this->followerAttachHandler = app()->get(FollowerAttachHandler::class);
        $this->followerDetachHandler = app()->get(FollowerDetachHandler::class);
    }

    /**
     * @throws \Throwable
     */
    public function subscribe(string $userId): Response|Application|ResponseFactory
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user === null) {
            throw new RuntimeException('Пользователь не найден');
        }

        $command = new FollowerAttachCommand(
                userOwnerId: $user->id,
                userSubscribeId: $userId
        );

        $this->followerAttachHandler->execute($command);

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
            throw new RuntimeException('Пользователь не найден');
        }

        $command = new FollowerDetachCommand(
            userOwnerId: $user->id,
            userSubscribeId: $userId
        );

        $this->followerDetachHandler->execute($command);

        return response(['success' => true]);
    }
}

