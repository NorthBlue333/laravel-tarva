<?php

namespace LaravelAdmin\Providers;

use LaravelAdmin\Http\Requests\ResourceCreateRequest;
use LaravelAdmin\Http\Requests\ResourceDetailRequest;
use LaravelAdmin\Http\Requests\ResourceIndexRequest;
use LaravelAdmin\Http\Requests\ResourceUpdateRequest;
use LaravelAdmin\Utils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AdminServiceProvider extends ServiceProvider
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
        View::share('adminResourceClasses', Utils::getResourceClasses());
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

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-admin');
        $this->loadViewComponentsAs('laravel-admin', [
            \LaravelAdmin\View\Components\Datatable::class,
            \LaravelAdmin\View\Components\Navigation::class,
            \LaravelAdmin\View\Components\Fields\View\Field::class,
            \LaravelAdmin\View\Components\Fields\View\Media::class,
            \LaravelAdmin\View\Components\Fields\View\Text::class,
            \LaravelAdmin\View\Components\Fields\View\Wysiwyg::class,
            \LaravelAdmin\View\Components\Fields\Form\Field::class,
            \LaravelAdmin\View\Components\Fields\Form\Media::class,
            \LaravelAdmin\View\Components\Fields\Form\Text::class,
            \LaravelAdmin\View\Components\Fields\Form\Wysiwyg::class,
        ]);


        $this->publishes([
            __DIR__.'/../../assets' => public_path('vendor/laravel-admin'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../config/laravel-admin.php' => config_path('laravel-admin.php'),
        ], 'config');
    }
}
