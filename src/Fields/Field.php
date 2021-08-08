<?php

namespace LaravelTarva\Fields;

use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceFormRequest;
use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceRequestInterface;
use LaravelTarva\Http\Requests\Resource\ResourceCreatingRequest;
use LaravelTarva\Http\Requests\Resource\ResourceUpdatingRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class Field
{
    /**
     * @todo should be protected
     */
    public string $name;
    public ?string $helper = null;
    public bool $showOnIndex = true;
    public bool $showOnDetail = true;
    public bool $showOnCreate = true;
    public bool $showOnUpdate = true;
    public string $components;
    public $defaultValue;

    protected $value;
    protected string $attribute;
    protected Collection $metadata;
    protected string $componentType;
    protected Collection $validationRules;
    protected $nullValues = [null, ''];
    protected $resolveCallback;
    protected $fillCallback;
    protected $componentTypeCallback = null;
    protected $sanitizeCallback = null;
    protected $displayCallback = null;

    public function __construct($name, $attribute)
    {
        $this->name = $name;
        $this->attribute = $attribute;
        $this->metadata = collect([]);
        $this->validationRules = collect([]);
    }

    /**
     * Set a default value for the form field
     *
     * @param mixed $defaultValue
     * @return self
     */
    public function defaultValue($defaultValue): self
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * Set a helper to provide additionnal information for the field
     *
     * @param string $helper
     * @return self
     */
    public function helper(string $helper): self
    {
        $this->helper = $helper;
        return $this;
    }

    /**
     * Set a custom resolve function
     *
     * @param \Closure $resolveCallback
     * @return self
     */
    public function resolveUsing(\Closure $resolveCallback): self
    {
        $this->resolveCallback = $resolveCallback;
        return $this;
    }

    /**
     * Set a custom fill function
     *
     * @param \Closure $fillCallback
     * @return self
     */
    public function fillUsing(\Closure $fillCallback): self
    {
        $this->fillCallback = $fillCallback;
        return $this;
    }

    /**
     * Set a custom sanitize function (no default). Gets ignore if fillCallback is callable.
     *
     * @param \Closure $sanitizeCallback
     * @return self
     */
    public function sanitizeUsing(\Closure $sanitizeCallback): self
    {
        $this->sanitizeCallback = $sanitizeCallback;
        return $this;
    }

    /**
     * Set field display callback
     *
     * @param string $type
     * @return self
     */
    public function displayUsing($callback) {
        return $this->displayCallback = $callback;
    }

    /**
     * Change field component type to show
     * Should be :
     * [
     *   ResourceCreatingRequest::class => 'index' | 'view' |'form',
     *   ResourceUpdatingRequest::class => 'index' | 'view' |'form',
     *   ResourceIndexRequest::class => 'index' | 'view' |'form',
     *   ResourceDetailRequest::class => 'index' | 'view' |'form',
     *   'form' => 'index' | 'view' |'form',
     * ]
     *
     * @return self
     */
    public final function componentType(array $typeMapping): self {
        $this->componentTypeCallback = function (ResourceRequestInterface $request) use ($typeMapping) {
            if (array_key_exists(get_class($request), $typeMapping)) {
                $this->componentType = $typeMapping[get_class($request)];
                return;
            }

            if (array_key_exists('form', $typeMapping) &&
                ($request instanceof ResourceUpdatingRequest || $request instanceof ResourceCreatingRequest)
            ) {
                $this->componentType = $typeMapping['form'];
                return;
            }
            $className = explode('\\', get_called_class());
            $this->componentType = $request::componentType() . array_pop($className);
        };
        return $this;
    }

    /**
     * Hide field from index
     *
     * @return self
     */
    public final function hideFromIndex(): self {
        $this->showOnIndex = false;
        return $this;
    }

    /**
     * Hide field from details
     *
     * @return self
     */
    public final function hideFromDetails(): self {
        $this->showOnDetail = false;
        return $this;
    }

    /**
     * Hide field when creating
     *
     * @return self
     */
    public final function hideWhenCreating(): self {
        $this->showOnCreate = false;
        return $this;
    }

    /**
     * Hide field when updating
     *
     * @return self
     */
    public final function hideWhenUpdating(): self {
        $this->showOnUpdate = false;
        return $this;
    }

    /**
     * Hide field from all forms
     *
     * @return self
     */
    public final function hideFromForms(): self {
        $this->hideWhenCreating();
        $this->hideWhenUpdating();
        return $this;
    }

    /**
     * Add disabled to metadata
     *
     * @return self
     */
    public final function disabled(): self {
        return $this->mergeMetaData(['disabled' => true]);
    }

    /**
     * Set validation rules for field
     *
     * @param array $rules
     * @return self
     */
    public final function rules(array $rules): self {
        $this->validationRules = $this->validationRules->merge($rules);
        return $this;
    }

    /**
     * Set component type callback
     *
     * @return self
     */
    public final function setComponentTypeCallback($callback): self {
        $this->componentTypeCallback = $callback;
        return $this;
    }

    /**
     * Get validation rules for field
     *
     * @return array
     */
    public function getValidationRules(): array {
        return [$this->attribute => $this->validationRules->toArray()];
    }

    /**
     * Get validation attribute for field
     *
     * @return array
     */
    public function getValidationAttribute(): array {
        return [$this->attribute => strtolower($this->name)];
    }

    /**
     * Get field value for display
     *
     * @return array
     */
    public function getValueForDisplay() {
        if(is_callable($this->displayCallback)) {
            return call_user_func($this->displayCallback);
        }
        return in_array($this->value, $this->nullValues) ? '—' : $this->getSerializableValue();
    }

    /**
     * If field is required
     *
     * @return array
     */
    public function isRequired(): bool {
        return $this->validationRules->contains('required');
    }

    /**
     * Get metadata
     *
     * @return Illuminate\Support\Collection
     */
    public final function getMetadata(): Collection {
        return $this->metadata;
    }

    /**
     * Get component name
     *
     * @return Illuminate\Support\Collection
     */
    public final function getComponentType(): string {
        return $this->componentType;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public final function getAttribute(): string {
        return $this->attribute;
    }

    /**
     * Get field value
     *
     * @return mixed
     */
    public final function getValue() {
        return $this->value;
    }

    /**
     * Get serialiazable field value
     */
    public function getSerializableValue() {
        return $this->getValue();
    }

    /**
     * @return void
     */
    protected function setComponentType(ResourceRequestInterface $request): void {
        if(is_callable($this->componentTypeCallback)) {
            call_user_func($this->componentTypeCallback, $request);
            return;
        }
        $className = explode('\\', get_called_class());
        $this->componentType = $request::componentType() . array_pop($className);
        return;
    }

    /**
     * Merge metadata with new values. New values override old ones
     *
     * @param array|Illuminate\Support\Collection $newMetadata
     * @return self
     */
    protected function mergeMetaData($newMetadata): self {
        $this->metadata = $this->metadata->merge($newMetadata)->filter(
            fn ($value, $key) => !in_array($key, ['name', 'class'])
        );
        return $this;
    }

    /**
     * Resolve field value for request
     *
     * @param Model $model
     * @param ResourceRequestInterface $request
     * @return void
     */
    public function resolveValue(Model $model, ResourceRequestInterface $request): void
    {
        $this->setComponentType($request);
        if($this->resolveCallback) {
            call_user_func($this->resolveCallback, $model);
            return;
        }
        $attributeSplitted = explode('->', $this->attribute);
        $value = $model->{$attributeSplitted[0]};
        if(!is_array($value) || count($attributeSplitted) === 1) {
            $this->value = $value;
            return;
        }
        $this->value = Arr::get($value, implode('.', array_slice($attributeSplitted, 1)));
    }

    /**
     * Fill model value from request
     *
     * @param Model $model
     * @param ResourceFormRequest $request
     * @return void
     */
    public function fillValue(Model $model, ResourceFormRequest $request): void
    {
        if(is_callable($this->fillCallback)) {
            call_user_func($this->fillCallback, $model, $request);
            return;
        }
        if(!$request->exists($this->attribute)) return;

        $value = $request->get($this->attribute);
        if(is_callable($this->sanitizeCallback)) {
            $value = call_user_func($this->sanitizeCallback, $value);
        }
        $model->{$this->attribute} = $value;
    }

    /**
     * Serialize field for forms
     * 
     * @return array
     */
    public function serializeForForms() {
        return [
            'isPanel' => false,
            'component' => $this->getComponentType(),
            'name' => $this->name,
            'helper' => $this->helper,
            'value' => $this->getSerializableValue(),
            'valueForDisplay' => $this->getValueForDisplay(),
            'metadata' => $this->getMetadata(),
            'isRequired' => $this->isRequired(),
            'attribute' => $this->getAttribute()
        ];
    }

    /**
     * Serialize field for index
     * 
     * @return array
     */
    public function serializeForIndex() {
        return [
            'isPanel' => false,
            'component' => $this->getComponentType(),
            'name' => $this->name,
            'valueForDisplay' => $this->getValueForDisplay()
        ];
    }

    /**
     * Serialize field for details
     * 
     * @return array
     */
    public function serializeForDetail() {
        return [
            'isPanel' => false,
            'component' => $this->getComponentType(),
            'name' => $this->name,
            'helper' => $this->helper,
            'valueForDisplay' => $this->getValueForDisplay(),
            'attribute' => $this->getAttribute(),
            'value' => $this->getSerializableValue(),
            'valueForDisplay' => $this->getValueForDisplay(),
        ];
    }

    /**
     * Get base name for the class (kebab case)
     *
     * @return string
     */
    public static function kebabName(): string {
        return Str::kebab(class_basename(get_called_class()), ' ');
    }
}
