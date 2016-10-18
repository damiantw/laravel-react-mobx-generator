<?php

namespace DamianTW\LaravelReactMobxGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use DamianTW\LaravelReactMobxGenerator\Console\CreateReactMobxApp;

class LaravelReactMobxGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateReactMobxApp::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}