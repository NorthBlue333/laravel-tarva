<?php

namespace LaravelAdmin\Http\Requests\Concerns;

trait HasResourceInstance {
    public function getResourceId() {
        return $this->route('id');
    }

    public function getResourceInstance() {
        return $this->getResourceClass()::forModelOrFail($this->getResourceId());
    }
}
