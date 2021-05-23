<?php

namespace LaravelAdmin\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;
use LaravelAdmin\Fields\Field;
use LaravelAdmin\Fields\Panel;
use LaravelAdmin\Http\Requests\ResourceIndexRequest;
use LaravelAdmin\Resources\Resource;
use LaravelAdmin\Utils;

class ResourceIndexController extends Controller
{
    public function index(ResourceIndexRequest $request, string $resource)
    {
        $resourceClass = Utils::findResource($resource);
        /** @todo should return inertia 404 */
        if(!$resourceClass) abort(404);
        $paginator = $resourceClass::$modelClass::simplePaginate($request->getPerPageResource());
        Inertia::setRootView('laravel-admin::layout');

        return Inertia::render('Resources/List', [
            'resource' => [
                'uriKey' => $resourceClass::uriKey(),
                'singular' => $resourceClass::singular(),
                'plural' => $resourceClass::plural(),
                'totalCount' => $resourceClass::$modelClass::count(),
            ],
            'resources' => $paginator->getCollection()
                ->map(fn (Model $model) => $resourceClass::forModelOrFail($model->getKey(), $request))
                ->map(function (Resource $r) {
                    $r->filterFieldsOn('showOnIndex', true);
                    return [
                        '_id' => $r->getModel()->getKey(),
                        'fields' => $r->getFields()
                            ->map(fn (Field|Panel $field) => is_a($field, Panel::class)
                                ? [
                                    'isPanel' => true,
                                    'name' => $field->name,
                                    'fields' => $field->getFields()->map(fn (Field $field) => [
                                            'component' => $field->getComponentType(),
                                            'name' => $field->name,
                                            'valueForDisplay' => $field->getValueForDisplay()
                                        ])
                                ]
                                : [
                                    'isPanel' => false,
                                    'component' => $field->getComponentType(),
                                    'name' => $field->name,
                                    'valueForDisplay' => $field->getValueForDisplay()
                                ])
                    ];
                }),
            'fields' => $resourceClass::staticFilterFieldsOn($resourceClass::fields(), 'showOnIndex', true)
                ->map(fn (Field|Panel $field) => is_a($field, Panel::class)
                    ? [
                        'isPanel' => true,
                        'name' => $field->name,
                        'fields' => $field->getFields()->map(fn (Field $field) => [
                                'name' => $field->name,
                            ])
                    ]
                    : [
                        'isPanel' => false,
                        'name' => $field->name,
                    ]),
            'pagination' => [
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'previous' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
            'filters' => $request->getFilters(),
            'filtersOptions' => $request->getFilterOptions(),
            'filtersDefaults' => $request->getFilterDefaults(),
        ])
        ->withViewData('pageTitle', $resourceClass::plural());
    }
}
