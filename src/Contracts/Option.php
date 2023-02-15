<?php

namespace Overtrue\LaravelOptions\Contracts;

interface Option
{
    public function has(string $key): bool;

    public function all(array $keys = []);

    public function get($key = null, $default = null);

    public function set($key, $value = null);

    public function remove($key);
}
