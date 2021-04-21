<?php

namespace LaravelAdmin\Http\Requests\Concerns;

use LaravelAdmin\Utils;

trait IsResourceRequest {
    public static function componentType(): string {
        return '';
    }

    public function getResourceClass(): string {
        return Utils::findResource($this->route('resource'));
    }
}
