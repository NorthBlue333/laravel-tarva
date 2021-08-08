<?php

namespace LaravelTarva\Http\Requests\Resource;

use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceInstanceRequest;

class ResourceUpdatingRequest extends ResourceInstanceRequest
{
    public static function componentType(): string {
        return 'form';
    }
}
