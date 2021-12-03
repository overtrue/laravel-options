<?php

/*
 * This file is part of the overtrue/laravel-options
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelOptions;

use Illuminate\Support\ServiceProvider;
use Overtrue\LaravelOptions\Console\Commands\SetOption;

/**
 * Class OptionsServiceProvider.
 */
class OptionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'laravel-options-migrations');

            $this->publishes([
                __DIR__ . '/../config/options.php' => \config_path('options.php'),
            ], 'laravel-options-config');

            $this->commands([
                SetOption::class,
            ], 'laravel-options-commands');
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/options.php', 'options');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('laravel-options', function ($app) {
            return new OptionsManager($app);
        });
    }
}
