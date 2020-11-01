<?php

namespace App\Providers;

use App\Contracts\Repositories\Admin\EventRepositoryContract;
use App\Repositories\Eloquents\Admin\EventEloquentRepository;
use App\Contracts\Repositories\Admin\AdminRepositoryContract;
use App\Repositories\Eloquents\Admin\AdminEloquentRepository;
use App\Contracts\Repositories\Admin\EntryRepositoryContract;
use App\Repositories\Eloquents\Admin\EntryEloquentRepository;
use App\Contracts\Repositories\Admin\UserRepositoryContract;
use App\Repositories\Eloquents\Admin\UserEloquentRepository;
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
    }

    public function boot()
    {
    }
}
