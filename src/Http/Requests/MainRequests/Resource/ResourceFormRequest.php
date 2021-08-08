<?php

namespace LaravelTarva\Http\Requests\MainRequests\Resource;

use LaravelTarva\Http\Requests\Concerns\IsResourceRequest;
use LaravelTarva\Http\Requests\Concerns\HasResourceValidation;
use Illuminate\Foundation\Http\FormRequest;

class ResourceFormRequest extends FormRequest implements ResourceRequestInterface
{
    use IsResourceRequest, HasResourceValidation;

    public static function componentType(): string {
        return 'Form';
    }
}
