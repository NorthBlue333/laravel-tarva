<?php

namespace LaravelTarva\Providers;

use LaravelTarva\Http\Requests\Resource\ResourceCreateRequest;
use LaravelTarva\Http\Requests\Resource\ResourceDetailRequest;
use LaravelTarva\Http\Requests\Resource\ResourceIndexRequest;
use LaravelTarva\Http\Requests\Resource\ResourceUpdateRequest;
use LaravelTarva\Utils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
class TarvaServiceProvider extends ServiceProvider
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $tarvaResourceClasses = Utils::getResourceClasses();
        $tarvaPageClasses = Utils::getPageClasses();
        View::share('tarvaResourceClasses', $tarvaResourceClasses);
        View::share('tarvaPageClasses', $tarvaPageClasses);
        Inertia::share('tarvaResourceClasses', collect($tarvaResourceClasses)->filter(fn ($class) => $class::$showInSidebar)->map(fn ($class) => [
            'uriKey' => $class::uriKey(),
            'singular' => $class::singular(),
            'plural' => $class::plural(),
            'icon' => $class::icon(),
        ]));
        Inertia::share('tarvaPageClasses', collect($tarvaPageClasses)->filter(fn ($class) => $class::$showInSidebar)->map(fn ($class) => [
            'uriKey' => $class::uriKey(),
            'name' => $class::name(),
            'icon' => $class::icon(),
        ]));
        Inertia::share('user',  fn (Request $request) => $request->user()
        ? $request->user()->only('id', 'email')
        : null);

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'courier');

        $this->app->bind(ResourceIndexRequest::class, function (Application $app) {
            return ResourceIndexRequest::createFrom($app->make(Request::class));
        });
        $this->app->bind(ResourceCreateRequest::class, function (Application $app) {
            return ResourceCreateRequest::createFrom($app->make(Request::class));
        });
        $this->app->bind(ResourceUpdateRequest::class, function (Application $app) {
            return ResourceUpdateRequest::createFrom($app->make(Request::class));
        });
        $this->app->bind(ResourceDetailRequest::class, function (Application $app) {
            return ResourceDetailRequest::createFrom($app->make(Request::class));
        });

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-tarva');

        $this->publishes([
            __DIR__.'/../../assets' => public_path('vendor/laravel-tarva'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../config/laravel-tarva.php' => config_path('laravel-tarva.php'),
        ], 'config');
    }
}
