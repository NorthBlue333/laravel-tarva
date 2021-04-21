<?php

namespace LaravelAdmin\Http\Controllers;

use LaravelAdmin\Fields\Panel;
use LaravelAdmin\Http\Requests\ResourceUpdateRequest;
use LaravelAdmin\Http\Requests\ResourceUpdatingRequest;
use LaravelAdmin\Utils;

class ResourceFormController extends Controller
{
    public function edit(ResourceUpdatingRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        return view('laravel-admin::resources.form', [
            'resourceInstance' => $resourceInstance,
            'panels' => $resourceInstance->getFields()->filter(fn ($field) => $field instanceof Panel)->prepend(
                (new Panel('__default', $resourceInstance->getFields()->filter(fn ($field) => !$field instanceof Panel)))
                    ->hideTitle()
            )->map(function (Panel $panel) {
                $panel->filterFieldsOn('showOnUpdate', true);
                return $panel;
            })->filter(fn ($panel) => $panel->getFields()->count()),
        ]);
    }

    public function update(ResourceUpdateRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        $resourceInstance->fillValues($request);
        return redirect()->route($request->get('__submit-redirect', 'laravel-admin::resources.show'), [
            'resource' => $resourceInstance::uriKey(),
            'id' => $resourceInstance->getModel()->getKey()
        ]);
    }
}
