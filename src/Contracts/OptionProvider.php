<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions\Contracts;

/**
 * Interface OptionProvider.
 */
interface OptionProvider
{
    /**
     * @param array $keys
     *
     * @return array
     */
    public function getAll(array $keys = []): array;

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function set(string $key, $value): OptionProvider;

    /**
     * @param array $options
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function multiSet(array $options): OptionProvider;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function remove(string $key): OptionProvider;

    /**
     * @param array $key
     *
     * @return mixed
     */
    public function multiRemove(array $keys): OptionProvider;
}
