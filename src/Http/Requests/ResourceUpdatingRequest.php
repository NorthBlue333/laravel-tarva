<?php

namespace LaravelAdmin\Http\Requests;

use LaravelAdmin\Http\Requests\Concerns\HasResourceInstance;
use LaravelAdmin\Http\Requests\MainRequests\ResourceInstanceRequest;

class ResourceUpdatingRequest extends ResourceInstanceRequest
{
    public static function componentType(): string {
        return 'form';
    }
}
