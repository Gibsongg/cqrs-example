<?php

use App\Post\Http\PostController;

use App\User\Http\Controllers\UserController;
use App\User\Http\Controllers\UserFollowController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/docs/', function () {
    return file_get_contents(resource_path('openapi.yaml'));
});

Route::post('auth/login', [UserController::class, 'login']);
Route::post('auth/registration', [UserController::class, 'registration']);
Route::post('user/{id}/profile', [UserController::class, 'editProfile']);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('user/follow/{userId}', [UserFollowController::class, 'subscribe']);

    Route::get('posts', [PostController::class, 'index']);
    Route::post('posts', [PostController::class, 'create']);
    Route::put('posts/{postId}', [PostController::class, 'update']);
    Route::post('posts/{postId}', [PostController::class, 'destroy']);

});
