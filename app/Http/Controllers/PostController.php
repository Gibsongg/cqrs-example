<?php

namespace App\Http\Controllers;

use App\Dto\Post\PostDto;
use App\Factories\Users\PostCreateFactory;
use App\Http\Requests\PostCreateRequest;
use App\Services\Commands\PostCommandService;
use App\Services\Queries\PostQueryService;
use Illuminate\Http\Response;

final class PostController extends Controller
{

    private PostCommandService $postCommandService;
    private PostQueryService $postQueryService;

    public function __construct()
    {
        $this->postCommandService = app()->get(PostCommandService::class);
        $this->postQueryService = app()->get(PostQueryService::class);
    }

    public function index(): Response
    {
        return response(
            [
                'data' => $this->postQueryService->postsList()
            ]
        );
    }

    /**
     * @throws \Throwable
     */
    public function create(PostCreateRequest $request): Response
    {
        $postDto = new PostDto($request->input());

        $postFactory = PostCreateFactory::factory($postDto);

        $this->postCommandService->create($postFactory);

        return response(['success' => true, 'id' => $postFactory->id]);
    }

    /**
     * @throws \Throwable
     */
    public function update(string $postId, PostCreateRequest $request): Response
    {
        $postDto = new PostDto();
        $postDto->title = $request->input('title');
        $postDto->message = $request->input('message');

        $this->postCommandService->update($postId, $postDto);

        return response(['success' => true]);
    }

    public function destroy(string $postId): Response
    {
        $this->postCommandService->delete($postId);

        return response(['success' => true]);
    }
}
