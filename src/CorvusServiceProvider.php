<?php

namespace CoolCatCoder\Corvus;

use CoolCatCoder\Corvus\Services\Corvus;
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

        $this->app->alias('Corvus', 'CoolCatCoder\Corvus\Facades\Corvus');
    }

    public function register(): void
    {
        $this->registerCorvus();
        $this->mergeConfig();
    }

    private function registerCorvus(): void
    {
        $this->app->singleton('corvus',function()
        {
            return new Corvus();
        });
    }

    private function mergeConfig(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'corvus'
        );
    }
}
