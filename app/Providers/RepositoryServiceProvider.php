<?php

namespace App\Providers;

use App\Contracts\Repositories\EventRepositoryContract;
use App\Repositories\Eloquents\EventEloquentRepository;
use App\Contracts\Repositories\User\UserRepositoryContract;
use App\Repositories\Eloquents\User\UserEloquentRepository;
use App\Contracts\Repositories\AdminRepositoryContract;
use App\Repositories\Eloquents\AdminEloquentRepository;
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
        app()->bind(AdminRepositoryContract::class, AdminEloquentRepository::class);
    }

    public function boot()
    {
    }
}
