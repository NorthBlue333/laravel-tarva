<?php

namespace LaravelTarva\Http\Requests\Concerns;

use Illuminate\Validation\Validator;

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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function () {
            $this->session()->flash('laravel-tarva--flash-messages', [
                'alerts' => [['type' => 'Error', 'title' => 'Could not update the resource, please fix incorrect fields']]
            ]);
        });
    }
}
