<?php

namespace bcdbuddy\PortfolioForm\Elements;

class File extends InputField
{

    protected $attributes = [
        'type' => 'file'
    ];

    function __construct ($label, $name)
    {
        parent::__construct($label, $name);
        $this->parentClass('file-field');
    }
}
