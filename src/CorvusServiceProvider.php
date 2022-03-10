<?php

namespace CoolCatCoder;

use CoolCatCoder\Services\Corvus;
use Illuminate\Support\ServiceProvider;

class CorvusServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/corvus.php' => config_path('corvus.php'),
        ]);

        $this->app->alias('Corvus', 'CoolCoder\Corvus\Facades\Corvus');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('corvus',function($app)
        {
            return new Corvus();
        });
    }
}
