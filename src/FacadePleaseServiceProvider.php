<?php

namespace Nauvalazhar\FacadePlease;

use Illuminate\Support\ServiceProvider;

class FacadePleaseServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Nauvalazhar\FacadePlease\Commands\FacadePlease',
        'Nauvalazhar\FacadePlease\Commands\FacadePleaseCreate',
        'Nauvalazhar\FacadePlease\Commands\FacadePleaseDelete',
        'Nauvalazhar\FacadePlease\Commands\FacadePleaseList',
        'Nauvalazhar\FacadePlease\Commands\FacadePleaseDiag',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/facadeplease.php' => config_path('facadeplease.php')
        ], 'facadeplease');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/facadeplease.php','facadeplease');
        $this->commands($this->commands);
    }
}
