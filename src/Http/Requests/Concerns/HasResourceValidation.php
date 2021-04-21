<?php

namespace LaravelAdmin\Http\Requests\Concerns;

trait HasResourceValidation {

    public function authorize() {
        return !!$this->user();
    }

    public function rules() {
        return $this->getResourceClass()::getValidationRules();
    }

    public function attributes() {
        return $this->getResourceClass()::getValidationAttributes();
    }
}
