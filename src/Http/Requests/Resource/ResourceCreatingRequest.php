<?php

namespace LaravelTarva\Http\Requests\Resource;

use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceRequest;

class ResourceCreatingRequest extends ResourceRequest
{
    public static function componentType(): string {
        return 'form';
    }
}
