<?php

namespace LaravelTarva\Http\Controllers;

use Inertia\Inertia;
use LaravelTarva\Fields\Field;
use LaravelTarva\Fields\Panel;
use LaravelTarva\Http\Requests\Resource\ResourceUpdateRequest;
use LaravelTarva\Http\Requests\Resource\ResourceUpdatingRequest;
use LaravelTarva\Utils;

class ResourceFormController extends Controller
{
    public function edit(ResourceUpdatingRequest $request, string $resource, string $id)
    {
        $resourceClass = Utils::findResource($resource);
        if(!$resourceClass) abort(404);
        $resourceInstance = $resourceClass::forModelOrFail($id, $request);
        Inertia::setRootView('laravel-tarva::layout');
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
                        ->map(fn (Field $field) => $field->serializeForForms())
                ]),
            ],
        ]);
    }

    public function update(ResourceUpdateRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        $resourceInstance->fillValues($request);
        $redirectRoute = $request->get('__submit-redirect', 'laravel-tarva::resources.show');
        return redirect()->route(
            in_array(
                $redirectRoute,
                ['laravel-tarva::resources.show', 'laravel-tarva::resources.edit']
            ) ? $redirectRoute : 'laravel-tarva::resources.show', [
            'resource' => $resourceInstance::uriKey(),
            'id' => $resourceInstance->getModel()->getKey()
        ])->with('laravel-tarva--flash-messages', [
            'alerts' => [['type' => 'Success', 'title' => 'You have successfully updated this resource']]
        ]);
    }
}
