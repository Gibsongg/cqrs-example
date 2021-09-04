<?php

namespace App\Providers;

use App\Post\Domain\Repositories\PostRepositoryInterface;
use App\Post\Repositories\PostRepository;
use App\User\Domain\Repositories\UserFollowerRepositoryInterface;
use App\User\Domain\Repositories\UserRepositoryInterface;
use App\User\Repositories\UserFollowerRepository;
use App\User\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserFollowerRepositoryInterface::class, UserFollowerRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

    }
}
