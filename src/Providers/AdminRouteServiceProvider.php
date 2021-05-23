<?php

namespace LaravelAdmin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use LaravelAdmin\Http\Middleware\Authenticate;
use LaravelAdmin\Http\Controllers\AdminController;

class AdminRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'LaravelAdmin\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $middlewares = config('laravel-admin.middlewares', []);
        $customMiddlewares =
        Route::middleware([
            ...array_filter($middlewares, fn ($middleware) => $middleware !== 'auth'),
            ...(in_array('auth', $middlewares) ? [Authenticate::class] : []),
        ])->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });

        if(in_array('auth', $middlewares)) {
            Route::middleware(
                array_filter($middlewares, fn ($middleware) => $middleware !== 'auth')
            )->get('/admin/login', [AdminController::class, 'login'])->name('laravel-admin::login');
        }
    }
}
