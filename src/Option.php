<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Option.
 */
class Option extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'key' => 'string',
        'value' => 'json',
    ];
}
