<?php

namespace Overtrue\LaravelOptions;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelOptions\Events\OptionCreated;
use Overtrue\LaravelOptions\Events\OptionDeleted;
use Overtrue\LaravelOptions\Events\OptionRetrieved;
use Overtrue\LaravelOptions\Events\OptionSaved;
use Overtrue\LaravelOptions\Events\OptionUpdated;

class Option extends Model
{
    protected $fillable = [
        'key', 'value',
    ];

    protected $casts = [
        'key' => 'string',
        'value' => 'json',
    ];

    protected $dispatchesEvents = [
        'created' => OptionCreated::class,
        'saved' => OptionSaved::class,
        'updated' => OptionUpdated::class,
        'deleted' => OptionDeleted::class,
        'retrieved' => OptionRetrieved::class,
    ];
}
