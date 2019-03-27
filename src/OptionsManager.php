<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions;

use Illuminate\Contracts\Foundation\Application;

class OptionsManager implements \Overtrue\LaravelOptions\Contracts\Option
{
    use CreatesOptionProvider;

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The array of created "Providers".
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Create a new Option manager instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Attempt to get the provider from the local cache.
     *
     * @param string $name
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function provider($name = null)
    {
        $name = $name ?: $this->getDefaultProvider();

        return $this->providers[$name] ?? $this->providers[$name] = $this->createOptionProvider($name);
    }

    /**
     * Get the default option Provider name.
     *
     * @return string
     */
    public function getDefaultProvider()
    {
        return $this->app['config']['options.defaults.provider'];
    }

    /**
     * Set the default option Provider name.
     *
     * @param string $name
     */
    public function setDefaultProvider($name)
    {
        $this->app['config']['options.defaults.provider'] = $name;
    }

    /**
     * Dynamically call the default Provider instance.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->provider()->{$method}(...$parameters);
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    public function all(array $keys = [])
    {
        return $this->provider()->getAll($keys);
    }

    /**
     * @param string|array $key
     * @param null         $default
     *
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (empty($key) || \is_array($key)) {
            return $this->provider()->getAll($key);
        }

        return $this->provider()->get($key, $default) ?? $default;
    }

    /**
     * @param      $key
     * @param null $value
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function set($key, $value = null)
    {
        if (\is_array($key)) {
            return $this->provider()->multiSet($key);
        }

        return $this->provider()->set($key, $value);
    }

    /**
     * @param string|array $key
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function remove($key)
    {
        if (\is_array($key)) {
            return $this->provider()->multiRemove($key);
        }

        return $this->provider()->remove($key);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->provider()->has($key);
    }
}
