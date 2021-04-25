<?php

namespace App\Providers;

use App\Contracts\Repositories\EventRepositoryContract;
use App\Repositories\Eloquents\EventEloquentRepository;
use App\Contracts\Repositories\AdminRepositoryContract;
use App\Repositories\Eloquents\AdminEloquentRepository;
use App\Contracts\Repositories\EntryRepositoryContract;
use App\Repositories\Eloquents\EntryEloquentRepository;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Repositories\Eloquents\UserEloquentRepository;
use App\Contracts\Repositories\CircleRepositoryContract;
use App\Repositories\Eloquents\CircleEloquentRepository;
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
        app()->bind(EntryRepositoryContract::class, EntryEloquentRepository::class);
        app()->bind(CircleRepositoryContract::class, CircleEloquentRepository::class);
    }

    public function boot()
    {
    }
}
