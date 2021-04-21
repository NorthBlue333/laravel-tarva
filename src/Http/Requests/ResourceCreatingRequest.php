<?php

namespace LaravelAdmin\Http\Requests;

use LaravelAdmin\Http\Requests\MainRequests\ResourceRequest;

class ResourceCreatingRequest extends ResourceRequest
{
    public static function componentType(): string {
        return 'form';
    }
}
