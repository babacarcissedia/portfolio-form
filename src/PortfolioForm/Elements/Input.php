<?php

namespace bcdbuddy\PortfolioForm\Elements;

abstract class Input extends Element
{
    protected $attributes = [
        "name" => ""
    ];

    function __construct($name)
    {
        $this->attributes["name"] = $name;
        $this->attributes["id"] = $name;
    }

    public function render()
    {
        return sprintf('<input%s>', $this->renderAttributes());
    }

    public function value($value)
    {
        $this->setValue($value);

        return $this;
    }

    protected function setValue($value)
    {
        $this->setAttribute('value', $value);

        return $this;
    }
}
