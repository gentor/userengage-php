<?php

namespace Gentor\Userengage;


use Illuminate\Support\ServiceProvider;

class UserengageServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('userengage', function ($app) {
            return new UserengageService($app['config']['userengage']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['userengage'];
    }

}