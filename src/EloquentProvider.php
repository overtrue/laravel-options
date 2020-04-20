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

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelOptions\Contracts\OptionProvider;

/**
 * Class EloquentProvider.
 */
class EloquentProvider implements OptionProvider
{
    /**
     * @var \Overtrue\LaravelOptions\Model
     */
    protected $option;

    /**
     * EloquentProvider constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $option
     */
    public function __construct(Model $option)
    {
        $this->option = $option;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->option->where('key', $key)->exists();
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    public function getAll(array $keys = []): array
    {
        return $this->option->when(!empty($keys), function ($query) use ($keys) {
            $query->whereIn('key', $keys);
        })->pluck('value', 'key')->toArray();
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->option->firstOrNew(\compact('key'), ['value' => $default])->value;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function set(string $key, $value): OptionProvider
    {
        $this->option->updateOrCreate(\compact('key'), \compact('value'));

        return $this;
    }

    /**
     * @param array $options
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function multiSet(array $options): OptionProvider
    {
        foreach ($options as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param string|array $key
     *
     * @return mixed
     */
    public function remove(string $key): OptionProvider
    {
        $option = $this->option->where('key', $key)->first();

        $option && $option->delete();

        return $this;
    }

    /**
     * @param array $keys
     *
     * @return mixed
     */
    public function multiRemove(array $keys): OptionProvider
    {
        foreach ($keys as $key) {
            $this->remove($key);
        }

        return $this;
    }
}
