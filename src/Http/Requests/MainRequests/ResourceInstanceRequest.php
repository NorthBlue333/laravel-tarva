<?php

namespace LaravelAdmin\Http\Requests\MainRequests;

use LaravelAdmin\Http\Requests\Concerns\IsResourceRequest;
use LaravelAdmin\Http\Requests\Concerns\HasResourceInstance;

class ResourceInstanceRequest extends ResourceRequest
{
    use IsResourceRequest, HasResourceInstance;

    public static function componentType(): string {
        return 'View';
    }
}
