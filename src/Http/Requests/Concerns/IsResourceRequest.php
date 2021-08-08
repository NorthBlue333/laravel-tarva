<?php

namespace LaravelTarva\Http\Requests\Concerns;

use LaravelTarva\Utils;

trait IsResourceRequest {
    public static function componentType(): string {
        return '';
    }

    public function getResourceClass(): string {
        return Utils::findResource($this->route('resource'));
    }
}
