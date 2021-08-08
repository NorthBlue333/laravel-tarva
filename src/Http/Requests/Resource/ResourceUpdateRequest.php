<?php

namespace LaravelTarva\Http\Requests\Resource;

use LaravelTarva\Http\Requests\Concerns\HasResourceInstance;
use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceFormRequest;

class ResourceUpdateRequest extends ResourceFormRequest
{
    use HasResourceInstance;
}
