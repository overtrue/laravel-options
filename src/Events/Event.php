<?php

namespace Overtrue\LaravelOptions\Events;

use Illuminate\Database\Eloquent\Model;

class Event
{
    public function __construct(public Model $option)
    {
    }
}
