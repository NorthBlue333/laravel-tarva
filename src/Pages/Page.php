<?php

namespace LaravelTarva\Pages;

use Illuminate\Support\Str;
use LaravelTarva\Http\Requests\MainRequests\Resource\ResourceRequestInterface;

class Page
{
    protected array $additionalCssFiles = [];
    protected array $additionalJsFiles = [];

    /**
     * Should show in sidebar in admin panel
     */
    public static bool $showInSidebar = true;

    public function __construct(ResourceRequestInterface $request)
    {
        $this->serialize($request);
    }

    /**
     * Set additional css files to load
     * If no file is specified, the page will try to load
     * asset('css/laravel-tarva/uri-key.css')
     *
     * @return self
     */
    public function additionalCssFiles(array $additionalCssFiles): self {
        $this->additionalCssFiles = $additionalCssFiles;
        return $this;
    }

    /**
     * Set additional js files to load
     * If no file is specified, the page will try to load
     * asset('js/laravel-tarva/uri-key.js')
     *
     * @return self
     */
    public function additionalJsFiles(array $additionalJsFiles): self {
        $this->additionalJsFiles = $additionalJsFiles;
        return $this;
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
     * Get name label for the page
     *
     * @return string
     */
    public static function name(): string {
        return __(static::baseName());
    }

    /**
     * Get uri key for the page
     *
     * @return string
     */
    public static function uriKey(): string {
        return Str::kebab(Str::lower(class_basename(get_called_class())), ' ');
    }

    /**
     * Get icon class for the page (fontawesome)
     *
     * @return string
     */
    public static function icon(): string {
        return '';
    }

    /**
     * Serialize to send parameters to the page
     * This method is meant to be overriden
     *
     * @return array
     */
    public function serialize(): array {
        return [];
    }

    /**
     * Component to render for the page
     */
    public function component(): string {
        return '';
    }
}
