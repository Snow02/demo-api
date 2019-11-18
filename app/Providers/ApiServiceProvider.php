<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Interfaces\PostRepositoryInterface',
            'App\Repositories\Eloquent\PostRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\CategoryRepositoryInterface',
            'App\Repositories\Eloquent\CategoryRepository'
        );
        $this->app->bind(
            'App\Repositories\Interfaces\UserRepositoryInterface',
            'App\Repositories\Eloquent\UserRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
