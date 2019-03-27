<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions\Events;

use Illuminate\Database\Eloquent\Model;

class Event
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $option;

    /**
     * Event constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $option
     */
    public function __construct(Model $option)
    {
        $this->option = $option;
    }
}
