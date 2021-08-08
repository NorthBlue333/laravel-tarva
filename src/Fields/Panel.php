<?php

namespace LaravelTarva\Fields;

use LaravelTarva\FieldCollection;
use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceRequestInterface;
use Illuminate\Database\Eloquent\Model;

class Panel
{
    public string $name;
    protected FieldCollection $fields;
    public bool $showTitle = true;

    public function __construct($name, $fields)
    {
        $this->name = $name;
        $this->fields = new FieldCollection($fields);
    }

    public function resolveValue(Model $model, ResourceRequestInterface $request): void
    {
        foreach ($this->fields as $field) {
            $field->resolveValue($model, $request);
        }
    }

    public function fillValue(Model $model, ResourceRequestInterface $request): void
    {
        foreach ($this->fields as $field) {
            $field->fillValue($model, $request);
        }
    }

    public final function hideTitle(): self {
        $this->showTitle = false;
        return $this;
    }

    public function filterFieldsOn(string $attribute, $value) {
        $this->fields = $this->fields->filter(fn ($field) => $field->{$attribute} === $value);
    }

    /**
     * Get fields for the panel
     *
     * @return FieldCollection
     */
    public function getFields(): FieldCollection
    {
        return $this->fields;
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array {
        return $this->fields->mapWithKeys(fn ($field) => $field->getValidationRules())->toArray();
    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public function getValidationAttribute(): array {
        return $this->fields->mapWithKeys(fn ($field) => $field->getValidationAttribute())->toArray();
    }
}
