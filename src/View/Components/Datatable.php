<?php

namespace LaravelAdmin\View\Components;

use LaravelAdmin\FieldCollection;
use LaravelAdmin\Fields\Panel;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Datatable extends Component
{
    public FieldCollection $fields;
    public Collection $resources;
    public int $resourceCount;
    public array $navigationLinks;
    public int $currentPage;
    public int $perPage;
    public string $resourceClass;
    public array $filters;
    public array $filtersOptions;
    public array $filtersDefaults;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $resources,
        int $resourceCount,
        array $navigationLinks,
        int $currentPage,
        int $perPage,
        string $resourceClass,
        array $filters,
        array $filtersOptions,
        array $filtersDefaults
    )
    {
        $this->resourceClass = $resourceClass;
        $this->fields = $resourceClass::fields()->map(function ($field) {
            if(!($field instanceof Panel)) {
                if(!$field->showOnIndex) return null;
                return $field;
            }
            $field->filterFieldsOn('showOnIndex', true);
            return $field;
        })->filter();
        $this->resources = $resources;
        $this->resourceCount = $resourceCount;
        $this->navigationLinks = $navigationLinks;
        $this->currentPage = $currentPage;
        $this->perPage = $perPage;
        $this->filters = $filters;
        $this->filtersOptions = $filtersOptions;
        $this->filtersDefaults = $filtersDefaults;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('laravel-admin::components.datatable');
    }
}
