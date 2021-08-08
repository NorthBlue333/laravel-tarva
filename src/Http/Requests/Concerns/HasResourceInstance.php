<?php

namespace LaravelTarva\Http\Requests\Concerns;

trait HasResourceInstance {
    public function getResourceId() {
        return $this->get('id');
    }

    public function getResourceInstance() {
        return $this->getResourceClass()::forModelOrFail($this->getResourceId());
    }
}
