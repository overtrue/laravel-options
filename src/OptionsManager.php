<?php

namespace Overtrue\LaravelOptions;

use Illuminate\Contracts\Foundation\Application;

class OptionsManager implements \Overtrue\LaravelOptions\Contracts\Option
{
    use CreatesOptionProvider;

    protected $providers = [];

    public function __construct(protected Application $app)
    {
    }

    public function provider(string $name = null)
    {
        $name = $name ?: $this->getDefaultProvider();

        return $this->providers[$name] ?? $this->providers[$name] = $this->createOptionProvider($name);
    }

    public function getDefaultProvider(): string
    {
        return $this->app['config']['options.defaults.provider'];
    }

    public function setDefaultProvider(string $name)
    {
        $this->app['config']['options.defaults.provider'] = $name;
    }

    public function __call($method, $parameters)
    {
        return $this->provider()->{$method}(...$parameters);
    }

    public function all(array $keys = [])
    {
        return $this->provider()->getAll($keys);
    }

    public function get($key = null, $default = null)
    {
        if (empty($key) || \is_array($key)) {
            return $this->provider()->getAll($key);
        }

        return $this->provider()->get($key, $default) ?? $default;
    }

    public function set($key, $value = null)
    {
        if (\is_array($key)) {
            return $this->provider()->multiSet($key);
        }

        return $this->provider()->set($key, $value);
    }

    public function remove($key)
    {
        if (\is_array($key)) {
            return $this->provider()->multiRemove($key);
        }

        return $this->provider()->remove($key);
    }

    public function has(string $key): bool
    {
        return $this->provider()->has($key);
    }
}
