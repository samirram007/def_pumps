<?php

namespace App\Providers;

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
        $this->app->bind( App\Repositories\Interfaces\SupportRepositoryInterface::class,App\Repositories\SupportRepository::class);
        $this->app->bind(App\Services\Interfaces\SupportServiceInterface::class, App\Services\SupportService::class);
        $this->app->bind( App\Repositories\Interfaces\OfficeRepositoryInterface::class,App\Repositories\OfficeRepository::class);
        $this->app->bind(App\Services\Interfaces\officeServiceInterface::class, App\Services\OfficeService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


    }
}
