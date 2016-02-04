<?php

namespace NineCells\SimpleBoard;

use Illuminate\Support\ServiceProvider;

class SimpleBoardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ncells');

        /*
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');
        */
    }

    public function register()
    {
    }
}
