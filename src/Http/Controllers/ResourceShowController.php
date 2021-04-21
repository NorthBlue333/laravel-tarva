<?php

namespace LaravelAdmin\Http\Controllers;

use LaravelAdmin\Fields\Panel;
use LaravelAdmin\Http\Requests\ResourceDetailRequest;
use LaravelAdmin\Utils;

class ResourceShowController extends Controller
{
    public function show(ResourceDetailRequest $request, string $resource, string $id)
    {
        $resource = Utils::findResource($resource);
        if(!$resource) abort(404);
        $resourceInstance = $resource::forModelOrFail($id, $request);
        return view('laravel-admin::resources.show', [
            'resourceInstance' => $resourceInstance,
            'panels' => $resourceInstance->getFields()->filter(fn ($field) => $field instanceof Panel)->prepend(
                (new Panel('__default', $resourceInstance->getFields()->filter(fn ($field) => !$field instanceof Panel)))
                    ->hideTitle()
            ),
        ]);
    }
}
