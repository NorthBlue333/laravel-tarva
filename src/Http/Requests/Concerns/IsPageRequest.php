<?php

namespace LaravelTarva\Http\Requests\Concerns;

use LaravelTarva\Utils;

trait IsPageRequest {
    public static function componentType(): string {
        return '';
    }

    public function getPageClass(): string {
        return Utils::findPage($this->route('page'));
    }
}
