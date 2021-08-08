<?php

namespace LaravelTarva\Fields;

class Text extends Field
{
    public function __construct($name, $attribute)
    {
        parent::__construct($name, $attribute);
        $this->mergeMetaData(['type' => 'text']);
    }

    /**
     * Set field type
     *
     * @param string $type
     * @return self
     */
    public function fieldType(string $type): self {
        return $this->mergeMetaData(['type' => $type]);
    }
}
