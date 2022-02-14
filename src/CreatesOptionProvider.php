<?php

namespace Overtrue\LaravelOptions;

use InvalidArgumentException;

trait CreatesOptionProvider
{
    protected array $customCreators = [];

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

    protected function getProviderConfig($name)
    {
        return $this->app['config']["options.providers.{$name}"];
    }

    protected function callCustomCreator($name, array $config)
    {
        return $this->customCreators[$name]($this->app, $name, $config);
    }

    public function extend($driver, \Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    protected function createEloquentProvider($config)
    {
        return new EloquentProvider($this->app[$config['model']]);
    }
}
