<?php

namespace App\Providers;

use App\Contracts\Repositories\EventRepositoryContract;
use App\Repositories\Eloquents\EventEloquentRepository;
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
    }

    public function boot()
    {
    }
}
