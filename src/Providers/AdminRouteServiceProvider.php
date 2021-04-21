<?php

namespace LaravelAdmin\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

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
        Route::middleware(config('laravel-admin.middlewares', []))->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });
    }
}
