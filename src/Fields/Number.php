<?php

namespace LaravelTarva\Fields;

class Number extends Text
{
    public ?int $min = null;
    public ?int $max = null;

    public function min(int $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max): self
    {
        $this->max = $max;
        return $this;
    }
}
