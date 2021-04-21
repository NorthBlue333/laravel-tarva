<?php

namespace LaravelAdmin\View\Components;

use Illuminate\View\Component;

class Navigation extends Component
{
    public string $contentId;
    public string $classesToToggle;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $contentId = null, string $classesToToggle = null)
    {
        $this->contentId = $contentId;
        $this->classesToToggle = $classesToToggle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('laravel-admin::components.navigation', [
            'contentId' => $this->contentId,
            'classesToToggle' => $this->classesToToggle,
        ]);
    }
}
