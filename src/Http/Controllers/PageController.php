<?php

namespace LaravelTarva\Http\Controllers;

use Inertia\Inertia;
use LaravelTarva\Fields\Field;
use LaravelTarva\Fields\Panel;
use LaravelTarva\Http\Requests\Page\PageRequest;
use LaravelTarva\Utils;

class PageController extends Controller
{
    public function show(PageRequest $request, string $page)
    {
        $page = Utils::findPage($page);
        if(!$page) abort(404);
        Inertia::setRootView('laravel-tarva::layout');
        $pageInstance = new $page($request);

        return Inertia::render('Pages/Show', [
            'page' => array_merge([
                'icon' => $page::icon(),
                'name' => $page::name(),
                'uriKey' => $page::uriKey(),
                'component' => $pageInstance->component(),
                'additionalCssFiles' => $pageInstance->additionalCssFiles()
                    ?: [asset('css/laravel-tarva/'. $page::uriKey() .'.css')],
                'additionalJsFiles' => $pageInstance->additionalJsFiles()
                    ?: [asset('js/laravel-tarva/'. $page::uriKey() .'.js')],
            ], $pageInstance->serialize()),
        ]);
    }
}
