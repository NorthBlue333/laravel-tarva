<?php

namespace LaravelAdmin\Fields;

use Error;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use LaravelAdmin\Http\Requests\MainRequests\ResourceFormRequest;
use LaravelAdmin\Http\Requests\MainRequests\ResourceRequestInterface;

class Media extends Field
{
    protected string $collectionName;
    protected string $disk;
    protected bool $isMultiple = false;
    protected bool $withResponsiveImages = false;

    public function __construct($name, $collectionName, $disk = 'media')
    {
        parent::__construct($name, 'medias-' . $collectionName);
        $this->collectionName = $collectionName;
        $this->disk = $disk;
        $this->hideFromIndex();
    }

    /**
     * Set if field is multiple
     *
     * @return self
     */
    public function multiple() {
        $this->isMultiple = true;
        return $this->mergeMetaData(['multiple' => true]);
    }

    /**
     * Automatically create responsive images
     *
     * @return self
     */
    public function withResponsiveImages() {
        $this->withResponsiveImages = true;
        return $this;
    }

    /**
     * Get if field is multiple
     *
     * @return bool
     */
    public function isMultiple(): bool {
        return $this->isMultiple;
    }

    /**
     * Get validation rules for field
     *
     * @return array
     */
    public function getValidationRules(): array {
        return [$this->attribute => $this->validationRules->map(function($rule) {
            if($rule !== 'required') return $rule;
            return 'required_without:existing-' . $this->attribute;
        })->toArray()];
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
        $this->value = $model->getMedia($this->collectionName);
    }

    /**
     * Fill model value from request
     *
     * @param HasMedia $model
     * @param ResourceFormRequest $request
     * @return void
     */
    public function fillValue(Model $model, ResourceFormRequest $request): void
    {
        if(is_callable($this->fillCallback)) {
            call_user_func($this->fillCallback, $model, $request);
            return;
        }

        if(!is_subclass_of($model, HasMedia::class)) {
            throw new Error('Model does not implement ' . HasMedia::class . ' interface.');
        }

        if($this->isMultiple) {
            $this->handleFileDeletion($model, $request->get('existing-' . $this->attribute));
        }

        if(!$request->hasFile($this->attribute)) return;

        $mediaAttribute = $request->file($this->attribute);

        if($this->isMultiple) {
            $this->handleMultipleUploads($model, $mediaAttribute);
            return;
        }

        $this->handleSingleUpload($model);
    }

    /**
     * Handle multiple media upload
     *
     * @param HasMedia $model
     * @param array of Illuminate\Http\UploadedFile $medias
     * @return void
     */
    protected function handleMultipleUploads(Model $model, array $medias): void {
        foreach ($medias as $key => $media) {
            $addingMedia = $model->addMediaFromRequest($this->attribute . '[' . $key . ']');
            if($this->withResponsiveImages) {
                $addingMedia->withResponsiveImages();
            }
            $addingMedia->toMediaCollection($this->collectionName, $this->disk);
        }
    }

    /**
     * Undocumented function
     *
     * @param HasMedia $model
     * @param array|null of ids $existingFileIds
     * @return void
     */
    protected function handleFileDeletion(Model $model, ?array $existingFileIds): void {
        if(!$existingFileIds) {
            $model->clearMediaCollection($this->collectionName);
            return;
        }
        $model->clearMediaCollectionExcept(
            $this->collectionName,
            $model->getMedia($this->collectionName, fn ($media) => in_array($media->getKey(), $existingFileIds))
        );
    }

    /**
     * Handle single media upload
     *
     * @param HasMedia $model
     * @param UploadedFile $media
     * @return void
     */
    protected function handleSingleUpload(Model $model): void {
        $addingMedia = $model->addMediaFromRequest($this->attribute);
        if($this->withResponsiveImages) {
            $addingMedia->withResponsiveImages();
        }
        $addingMedia->toMediaCollection($this->collectionName, $this->disk);
    }
}
