<?php

namespace App\Post\Http;

use App\User\Http\Controllers\Controller;
use App\Post\Http\Requests\PostCreateRequest;
use App\Post\Domain\Commands\PostCreateCommand;
use App\Post\Domain\Commands\PostCreateHandler;
use App\Post\Domain\Commands\PostDestroyCommand;
use App\Post\Domain\Commands\PostDestroyHandler;
use App\Post\Domain\Commands\PostUpdateCommand;
use App\Post\Domain\Commands\PostUpdateHandler;
use App\Post\ReadModel\PostListHandler;
use App\Post\ReadModel\PostListQuery;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


final class PostController extends \App\Http\Controllers\Controller
{
    private PostListHandler $postListHandler;
    private PostCreateHandler $postCreateHandler;
    private PostUpdateHandler $postUpdateHandler;
    private PostDestroyHandler $postDestroyHandler;

    public function __construct()
    {
        $this->postListHandler = app()->get(PostListHandler::class);
        $this->postCreateHandler = app()->get(PostCreateHandler::class);
        $this->postUpdateHandler = app()->get(PostUpdateHandler::class);
        $this->postDestroyHandler = app()->get(PostDestroyHandler::class);
    }

    /**
     * Здесь за место сервиса с контроллером используем команду (DTO) и обработчик
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        $query = new PostListQuery();
        $query->userId = (string)Auth::id();

        return response(
            [
                'data' => $this->postListHandler->execute($query)
            ]
        );
    }

    /**
     * @throws \Throwable
     */
    public function create(PostCreateRequest $request): Response
    {
        $command = new PostCreateCommand(
            id: Str::uuid()->toString(),
            title: $request->input('title'),
            message: $request->input('message'),
            user_id: (string)Auth::id(),
        );

        $this->postCreateHandler->execute($command);

        return response(['success' => true, 'id' => $command->id]);
    }

    /**
     * @throws \Throwable
     */
    public function update(string $postId, PostCreateRequest $request): Response
    {
        $command = new PostUpdateCommand(
            id: $postId,
            title: $request->input('title'),
            message: $request->input('message'),
        );

        $this->postUpdateHandler->execute($command);

        return response(['success' => true]);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function destroy(string $postId): Response
    {
        $this->postDestroyHandler->execute(new PostDestroyCommand(id: $postId));

        return response(['success' => true]);
    }
}
