<?php

namespace LaravelAdmin\View\Components\Fields\Form;

use LaravelAdmin\Fields\Field as FieldsField;
use Illuminate\View\Component;

class Field extends Component
{
    protected FieldsField $field;

    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if(get_called_class() === Field::class) {
            return view('laravel-admin::components.fields.form.field', [
                'field' => $this->field,
            ]);
        }
        return view('laravel-admin::components.fields.form.' . $this->field::kebabName(), [
            'field' => $this->field,
        ]);
    }
}
