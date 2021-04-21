<?php

namespace LaravelAdmin\Fields;

class Number extends Text
{
    public ?int $min = null;
    public ?int $max = null;

    public function min(int $min)
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max)
    {
        $this->max = $max;
        return $this;
    }
}
