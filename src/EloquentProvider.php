<?php

namespace Overtrue\LaravelOptions;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelOptions\Contracts\OptionProvider;

class EloquentProvider implements OptionProvider
{
    public function __construct(protected Model $option)
    {
    }

    public function has(string $key): bool
    {
        return $this->option->where('key', $key)->exists();
    }

    public function getAll(array $keys = []): array
    {
        return $this->option->when(!empty($keys), function ($query) use ($keys) {
            $query->whereIn('key', $keys);
        })->pluck('value', 'key')->toArray();
    }

    public function get(string $key, $default = null)
    {
        return $this->option->firstOrNew(\compact('key'), ['value' => $default])->value;
    }

    public function set(string $key, $value): OptionProvider
    {
        $this->option->updateOrCreate(\compact('key'), \compact('value'));

        return $this;
    }

    public function multiSet(array $options): OptionProvider
    {
        foreach ($options as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    public function remove(string $key): OptionProvider
    {
        $option = $this->option->where('key', $key)->first();

        $option && $option->delete();

        return $this;
    }

    public function multiRemove(array $keys): OptionProvider
    {
        foreach ($keys as $key) {
            $this->remove($key);
        }

        return $this;
    }
}
