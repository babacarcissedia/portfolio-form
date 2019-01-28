<?php

namespace bcdbuddy\PortfolioForm\Elements;

class Submit extends Button
{
    protected $attributes = [
        "type" => "submit",
        "class" => "button"

    ];
    public function render()
    {
        return '<br/> '. parent::render();
    }
}