<?php

namespace LaravelAdmin\Http\Controllers;

use LaravelAdmin\Http\Requests\ResourceIndexRequest;
use LaravelAdmin\Utils;

class ResourceIndexController extends Controller
{
    public function index(ResourceIndexRequest $request, string $resource)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $paginator = $resource::$modelClass::simplePaginate($request->getPerPageResource());
        return view('laravel-admin::resources.list', [
            'resource' => $resource,
            'resources' => $paginator->getCollection()->map(fn ($model) => $resource::forModelOrFail($model->getKey(), $request))
                ->map(function ($resource) {
                    $resource->filterFieldsOn('showOnIndex', true);
                    return $resource;
                }),
            'resourceCount' => $resource::$modelClass::count(),
            'currentPage' => $paginator->currentPage(),
            'perPage' => $paginator->perPage(),
            'navigationLinks' => [
                'previous' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
            'filters' => $request->getFilters(),
            'filtersOptions' => $request->getFilterOptions(),
            'filtersDefaults' => $request->getFilterDefaults(),
        ]);
    }
}
