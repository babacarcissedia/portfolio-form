<?php
namespace bcdbuddy\PortfolioForm;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'portfolio-form';
    }
}
