<?php

namespace LaravelAdmin\Http\Requests;

use LaravelAdmin\Http\Requests\Concerns\HasResourceInstance;
use LaravelAdmin\Http\Requests\MainRequests\ResourceFormRequest;

class ResourceUpdateRequest extends ResourceFormRequest
{
    use HasResourceInstance;
}
