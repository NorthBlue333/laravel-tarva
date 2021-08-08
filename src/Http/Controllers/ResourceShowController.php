<?php

namespace LaravelTarva\Http\Controllers;

use Inertia\Inertia;
use LaravelTarva\Fields\Field;
use LaravelTarva\Fields\Panel;
use LaravelTarva\Http\Requests\Resource\ResourceDetailRequest;
use LaravelTarva\Utils;

class ResourceShowController extends Controller
{
    public function show(ResourceDetailRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        Inertia::setRootView('laravel-tarva::layout');

        return Inertia::render('Resources/Show', [
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
                    $panel->filterFieldsOn('showOnDetail', true);
                    return $panel;
                })->filter(fn ($panel) => $panel->getFields()->count())->map(fn (Panel $panel) => [
                    'name' => $panel->name,
                    'showTitle' => $panel->showTitle,
                    'fields' => $panel->getFields()
                        ->map(fn (Field $field) => $field->serializeForDetail())
                ]),
            ],
        ]);
    }
}
