<?php

namespace LaravelAdmin\Http\Controllers;

use Inertia\Inertia;
use LaravelAdmin\Fields\Field;
use LaravelAdmin\Fields\Panel;
use LaravelAdmin\Http\Requests\ResourceUpdateRequest;
use LaravelAdmin\Http\Requests\ResourceUpdatingRequest;
use LaravelAdmin\Utils;

class ResourceFormController extends Controller
{
    public function edit(ResourceUpdatingRequest $request, string $resource, string $id)
    {
        $resourceClass = Utils::findResource($resource);
        if(!$resourceClass) abort(404);
        $resourceInstance = $resourceClass::forModelOrFail($id, $request);
        Inertia::setRootView('laravel-admin::layout');
        return Inertia::render('Resources/Form', [
            'resource' => [
                'singular' => $resourceInstance::singular(),
                'plural' => $resourceInstance::plural(),
                'uriKey' => $resourceInstance::uriKey(),
                'title' => $resourceInstance->title(),
                '_id' => $resourceInstance->getModel()->getKey(),
                'panels' => $resourceInstance->getFields()->filter(fn ($field) => $field instanceof Panel)->prepend(
                    (new Panel('__default', $resourceInstance->getFields()->filter(fn ($field) => !$field instanceof Panel)))
                        ->hideTitle()
                )->map(function (Panel $panel) {
                    $panel->filterFieldsOn('showOnUpdate', true);
                    return $panel;
                })->filter(fn ($panel) => $panel->getFields()->count())->map(fn (Panel $panel) => [
                    'name' => $panel->name,
                    'showTitle' => $panel->showTitle,
                    'fields' => $panel->getFields()
                        ->map(fn (Field $field) => [
                            'isPanel' => false,
                            'component' => $field->getComponentType(),
                            'name' => $field->name,
                            'valueForDisplay' => $field->getValueForDisplay(),
                            'metadata' => $field->getMetadata(),
                            'isRequired' => $field->isRequired(),
                            'attribute' => $field->getAttribute()
                        ])
                ]),
            ],
        ])
        ->withViewData('pageTitle', 'Edit ' . $resourceInstance::singular() . ' ' . $resourceInstance->title());
    }

    public function update(ResourceUpdateRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        $resourceInstance->fillValues($request);
        $redirectRoute = $request->get('__submit-redirect', 'laravel-admin::resources.show');
        return redirect()->route(
            in_array(
                $redirectRoute,
                ['laravel-admin::resources.show', 'laravel-admin::resources.edit']
            ) ? $redirectRoute : 'laravel-admin::resources.show', [
            'resource' => $resourceInstance::uriKey(),
            'id' => $resourceInstance->getModel()->getKey()
        ]);
    }
}
