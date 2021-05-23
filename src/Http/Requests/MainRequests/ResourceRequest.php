<?php

namespace LaravelAdmin\Http\Requests\MainRequests;

use LaravelAdmin\Http\Requests\Concerns\IsResourceRequest;
use Illuminate\Http\Request;

class ResourceRequest extends Request implements ResourceRequestInterface {
    use IsResourceRequest;

    public static function componentType(): string {
        return 'Index';
    }
}
