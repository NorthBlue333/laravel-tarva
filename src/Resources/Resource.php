<?php

namespace LaravelAdmin\Resources;

use LaravelAdmin\Fields\Field;
use LaravelAdmin\Fields\Panel;
use Illuminate\Support\Str;
use LaravelAdmin\FieldCollection;
use Illuminate\Database\Eloquent\Model;
use LaravelAdmin\Http\Requests\MainRequests\ResourceRequestInterface;

class Resource
{
    /**
     * Current model instance
     */
    protected Model $model;

    /**
     * Fields for the resource filled by model values
     */
    protected FieldCollection $fields;

    /**
     * Model class for the resource
     */
    public static string $modelClass = '';

    /**
     * Model key to use as title
     */
    public static string $title = '';

    /**
     * Should show in sidebar in admin panel
     */
    public static bool $showInSidebar = true;

    public function __construct(Model $model, ResourceRequestInterface $request)
    {
        $this->model = $model;
        $this->fields = static::fields()->each(function ($field) use ($model, $request) {
            $field->resolveValue($model, $request);
        });
    }

    /**
     * Get list of fields for the resource
     * Overwritten in child classes
     *
     * @return FieldCollection
     */
    public static function fields(): FieldCollection
    {
        return new FieldCollection([]);
    }

    /**
     * Get title for resource
     *
     * @return mixed
     */
    public function title()
    {
        return $this->model->{static::$title ?: $this->model->getKeyName()};
    }

    /**
     * Refresh the model
     *
     * @return void
     */
    public function fresh(): void
    {
        $this->model->fresh();
    }

    /**
     * Get fields for the resource
     *
     * @return FieldCollection
     */
    public function getFields(): FieldCollection
    {
        return $this->fields;
    }

    public function filterFieldsOn(string $attribute, $value) {
        $this->fields = static::staticFilterFieldsOn($this->fields, $attribute, $value);
    }

    public static function staticFilterFieldsOn(FieldCollection $fields, string $attribute, $value) {
        return $fields->map(function ($field) use ($attribute, $value) {
            if(!($field instanceof Panel)) return $field;

            $field->filterFieldsOn($attribute, $value);
            return $field;
        })
        ->filter(fn ($field) => $field instanceof Panel && $field->getFields()->count() ||
            !($field instanceof Panel) && $field->{$attribute} === $value);

    }

    /**
     * Get validation rules
     *
     * @return array
     */
    public static function getValidationRules(): array {
        return static::fields()->mapWithKeys(fn ($field) => $field->getValidationRules())->toArray();
    }

    /**
     * Get validation attributes
     *
     * @return array
     */
    public static function getValidationAttributes(): array {
        return static::fields()->mapWithKeys(fn ($field) => $field->getValidationAttribute())->toArray();
    }

    /**
     * Get current model instance
     *
     * @return Model
     */
    final public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Get base name for the class (spaces and capitals)
     *
     * @return string
     */
    public static function baseName(): string {
        return Str::title(Str::snake(class_basename(get_called_class()), ' '));
    }

    /**
     * Get singular label for the resource
     *
     * @return string
     */
    public static function singular(): string {
        return __(Str::singular(static::baseName()));
    }

    /**
     * Get plural label for the resource
     *
     * @return string
     */
    public static function plural(): string {
        return __(Str::plural(static::baseName()));
    }

    /**
     * Get uri key for the resource
     *
     * @return string
     */
    public static function uriKey(): string {
        return Str::kebab(Str::plural(Str::lower(class_basename(get_called_class()))), ' ');
    }

    /**
     * Get icon class for the resource (fontawesome)
     *
     * @return string
     */
    public static function icon(): string {
        return '';
    }

    /**
     * Fill resource fields
     *
     * @param ResourceRequest $request
     * @return void
     */
    public function fillValues(ResourceRequestInterface $request)
    {
        $this->fields = static::fields()->each(function ($field) use ($request) {
            $field->fillValue($this->model, $request);
        });
        $this->model->save();
    }

    /**
     * Fetch model to create a new resource instance
     *
     * @param mixed $id
     * @return static
     */
    public static function forModel($id, $request) {
        $model = static::$modelClass::find($id);
        return new static($model, $request);
    }

    /**
     * Fetch model or fail to create a new resource instance
     *
     * @param mixed $id
     * @return static
     */
    public static function forModelOrFail($id, $request) {
        $model = static::$modelClass::findOrFail($id);
        return new static($model, $request);
    }
}
