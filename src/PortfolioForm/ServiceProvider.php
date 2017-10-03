<?php

namespace bcdbuddy\PortfolioForm;

use bcdbuddy\PortfolioForm\PortfolioForm;
use bcdbuddy\PortfolioForm\ErrorStore\IlluminateErrorStore;
use bcdbuddy\PortfolioForm\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class PackageServiceProvider
 *
 * @package bcdbuddy\PortfolioForm
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('portfolio-form', function ($app) {

            $builder = new PortfolioForm();
            $builder->setToken($app['session.store']->token());
            $builder->setErrorStore(new IlluminateErrorStore($app['session.store']));
            $builder->setOldInputProvider(new IlluminateOldInputProvider($app['session.store']));

            return $builder;
        });
    }

    /**
     * Application is booting
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views/'), 'portfolio-form');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['portfolio-form'];
    }
}
