<?php

namespace LaravelAdmin\Fields;

class Wysiwyg extends Field
{
    protected array $headingClasses = [];

    public function __construct($name, $attribute)
    {
        parent::__construct($name, $attribute);
        $this->hideFromIndex();
    }

    /**
     * Set heading classes
     *
     * @param array $headingClasses
     * @return self
     */
    public function headingClasses(array $headingClasses) {
        $this->headingClasses = $headingClasses;
        return $this;
    }

    public function getHeadingClasses(): array {
        return $this->headingClasses;
    }
}
