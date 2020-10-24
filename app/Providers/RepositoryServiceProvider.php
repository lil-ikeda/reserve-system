<?php

namespace App\Providers;

use App\Contracts\Repositories\Admin\EventRepositoryContract;
use App\Repositories\Eloquents\Admin\EventEloquentRepository;
use App\Contracts\Repositories\User\UserRepositoryContract;
use App\Repositories\Eloquents\User\UserEloquentRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(EventRepositoryContract::class, EventEloquentRepository::class);
        app()->bind(UserRepositoryContract::class, UserEloquentRepository::class);
    }

    public function boot()
    {
    }
}
