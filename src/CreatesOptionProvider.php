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

/**
 * Trait CreatesOptionProvider.
 */
trait CreatesOptionProvider
{
    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * Create the user provider implementation for the driver.
     *
     * @param string|null $provider
     *
     * @return mixed|\Overtrue\LaravelOptions\EloquentProvider|null
     *
     * @throws \InvalidArgumentException
     */
    public function createOptionProvider($provider = null)
    {
        if (is_null($config = $this->getProviderConfig($provider))) {
            return null;
        }

        if (isset($this->customCreators[$provider])) {
            return call_user_func(
                $this->customCreators[$provider],
                $this->app,
                $config
            );
        }

        $driver = $config['driver'] ?? null;

        switch ($driver) {
            case 'eloquent':
                return $this->createEloquentProvider($config);
            default:
                throw new InvalidArgumentException(
                    "Options provider [{$driver}] is not defined."
                );
        }
    }

    /**
     * Get the provider configuration.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getProviderConfig($name)
    {
        return $this->app['config']["options.providers.{$name}"];
    }

    /**
     * Call a custom driver creator.
     *
     * @param string $name
     * @param array  $config
     *
     * @return mixed
     */
    protected function callCustomCreator($name, array $config)
    {
        return $this->customCreators[$name]($this->app, $name, $config);
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param string   $driver
     * @param \Closure $callback
     *
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    /**
     * Create an instance of the Eloquent provider.
     *
     * @param array $config
     *
     * @return \Overtrue\LaravelOptions\EloquentProvider
     */
    protected function createEloquentProvider($config)
    {
        return new EloquentProvider($this->app[$config['model']]);
    }
}
