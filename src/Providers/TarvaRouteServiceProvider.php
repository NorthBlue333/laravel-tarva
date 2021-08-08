<?php

namespace LaravelTarva\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use LaravelTarva\Utils;
use LaravelTarva\Http\Middleware\Authenticate;
use LaravelTarva\Http\Controllers\TarvaController;

class TarvaRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'LaravelTarva\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $middlewares = config('laravel-tarva.middlewares', []);
        $routeFiles = Utils::getPageRoutes();
        Route::middleware([
            ...array_filter($middlewares, fn ($middleware) => $middleware !== 'auth'),
            ...(in_array('auth', $middlewares) ? [Authenticate::class] : []),
        ])->group(function () use ($routeFiles) {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
            foreach ($routeFiles as $routeFile) {
                $this->loadRoutesFrom($routeFile);
            }
        });

        if(in_array('auth', $middlewares)) {
            Route::middleware(
                array_filter($middlewares, fn ($middleware) => $middleware !== 'auth')
            )->get('/tarva/login', [TarvaController::class, 'login'])->name('laravel-tarva::login');
        }
    }
}
