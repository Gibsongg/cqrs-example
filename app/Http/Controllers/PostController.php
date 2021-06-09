<?php

namespace App\Http\Controllers;

use App\Dto\Post\PostDto;
use App\Http\Requests\PostCreateRequest;
use App\Services\PostService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class PostController extends Controller
{

    private PostService $postService;

    public function __construct()
    {
        $this->postService = app()->get(PostService::class);
    }

    public function index(): Response
    {
        $posts = $this->postService->postsList();

        return response(
            [
                'data' => $this->postService->postsList()
            ]
        );
    }

    /**
     * @throws \Throwable
     */
    public function create(PostCreateRequest $request): Response
    {
        $postDto = new PostDto($request->toArray());
        $postDto->user_id = Auth::id();

        $post = $this->postService->create($postDto);

        return response(['success' => true, 'id' => $post->id]);
    }

    public function update(string $postId, PostCreateRequest $request): Response
    {
        $postDto = new PostDto();
        $postDto->title = $request->input('title');
        $postDto->message = $request->input('message');

        $this->postService->update($postId, $postDto);

        return response(['success' => true]);
    }

    public function destroy(string $postId): Response
    {
        $this->postService->delete($postId);

        return response(['success' => true]);
    }
}
