<?php

namespace bcdbuddy\PortfolioForm\Elements;


class FontAwesomeIcon extends Element
{
    protected $attributes = [
        "class" => "fa"
    ];
    private $name;
    private $prefix;

    function __construct($name, $prefix=false)
    {
        $this->name = $name;
        $this->addClass('fa-' . $this->name);
        $this->prefix = $prefix;
    }

    public function render()
    {
        return implode('', [
            '<i ',
            $this->renderAttributes(),
            '></i>'
        ]);
    }
}