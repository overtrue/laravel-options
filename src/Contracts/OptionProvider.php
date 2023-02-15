<?php

namespace Overtrue\LaravelOptions\Contracts;

interface OptionProvider
{
    public function getAll(array $keys = []): array;

    public function get(string $key, $default = null);

    public function has(string $key): bool;

    public function set(string $key, $value): OptionProvider;

    public function multiSet(array $options): OptionProvider;

    public function remove(string $key): OptionProvider;

    public function multiRemove(array $keys): OptionProvider;
}
