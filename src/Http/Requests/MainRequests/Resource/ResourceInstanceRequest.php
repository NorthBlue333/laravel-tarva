<?php

namespace LaravelTarva\Http\Requests\MainRequests\Resource;

use LaravelTarva\Http\Requests\Concerns\IsResourceRequest;
use LaravelTarva\Http\Requests\Concerns\HasResourceInstance;

class ResourceInstanceRequest extends ResourceRequest
{
    use IsResourceRequest, HasResourceInstance;

    public static function componentType(): string {
        return 'View';
    }
}
