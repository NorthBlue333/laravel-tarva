<?php

namespace LaravelAdmin\Http\Requests\MainRequests;

use LaravelAdmin\Http\Requests\Concerns\IsResourceRequest;
use LaravelAdmin\Http\Requests\Concerns\HasResourceValidation;
use Illuminate\Foundation\Http\FormRequest;

class ResourceFormRequest extends FormRequest implements ResourceRequestInterface
{
    use IsResourceRequest, HasResourceValidation;

    public static function componentType(): string {
        return 'form';
    }
}
