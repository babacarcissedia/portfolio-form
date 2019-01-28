<?php

namespace bcdbuddy\PortfolioForm\Facades;

use Illuminate\Support\Facades\Facade;

class PortfolioForm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'portfolio-form';
    }
}
