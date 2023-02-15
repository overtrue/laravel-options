<?php

namespace Overtrue\LaravelOptions;

use Illuminate\Support\ServiceProvider;
use Overtrue\LaravelOptions\Console\Commands\SetOption;

class OptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'laravel-options-migrations');

            $this->publishes([
                __DIR__.'/../config/options.php' => \config_path('options.php'),
            ], 'laravel-options-config');

            $this->commands([
                SetOption::class,
            ], 'laravel-options-commands');
        }

        $this->mergeConfigFrom(__DIR__.'/../config/options.php', 'options');
    }

    public function register()
    {
        $this->app->bind('laravel-options', function ($app) {
            return new OptionsManager($app);
        });
    }
}
