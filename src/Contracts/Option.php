<?php

/*
 * This file is part of the overtrue/laravel-options
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelOptions\Contracts;

interface Option
{
    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param array $keys
     *
     * @return array
     */
    public function all(array $keys = []);

    /**
     * @param string|array $key
     * @param mixed        $default
     *
     * @return mixed
     */
    public function get($key = null, $default = null);

    /**
     * @param string|array $key
     * @param mixed|null   $value
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function set($key, $value = null);

    /**
     * @param string|array $key
     *
     * @return \Overtrue\LaravelOptions\Contracts\OptionProvider
     */
    public function remove($key);
}
