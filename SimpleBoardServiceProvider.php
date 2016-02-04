<?php

namespace NineCells\SimpleBoard;

use App;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\ServiceProvider;
use NineCells\Auth\AuthServiceProvider;

use NineCells\SimpleBoard\Console\CreateBoardCommand;
use NineCells\SimpleBoard\Console\DeleteBoardCommand;
use NineCells\SimpleBoard\Models\Post;
use NineCells\SimpleBoard\Models\Comment;
use NineCells\SimpleBoard\Policies\SimpleBoardPolicy;

class SimpleBoardServiceProvider extends ServiceProvider
{
    private $policies = [
        Post::class => SimpleBoardPolicy::class,
        Comment::class => SimpleBoardPolicy::class,
    ];

    private function registerPolicies(GateContract $gate)
    {
        $gate->before(function ($user, $ability) {
            if ($ability === "sboard-write") {
                return $user;
            }
        });

        foreach ($this->policies as $key => $value) {
            $gate->policy($key, $value);
        }
    }

    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ncells');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    public function register()
    {
        App::register(AuthServiceProvider::class);

        $this->registerCreateBoardCommand();
        $this->registerDeleteBoardCommand();
    }

    public function registerCreateBoardCommand()
    {
        $this->app->singleton('command.ninecells.sboard.create_board', function () {
            return new CreateBoardCommand();
        });

        $this->commands('command.ninecells.sboard.create_board');
    }

    public function registerDeleteBoardCommand()
    {
        $this->app->singleton('command.ninecells.sboard.delete_board', function () {
            return new DeleteBoardCommand();
        });

        $this->commands('command.ninecells.sboard.delete_board');
    }
}
