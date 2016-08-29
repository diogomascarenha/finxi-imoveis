<?php

namespace FinxiImoveis\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \FinxiImoveis\Repositories\ImovelRepository::class,
            \FinxiImoveis\Repositories\ImovelRepositoryEloquent::class
        );

        $this->app->bind(
            \FinxiImoveis\Repositories\ImovelStatusRepository::class,
            \FinxiImoveis\Repositories\ImovelStatusRepositoryEloquent::class
        );
    }
}
