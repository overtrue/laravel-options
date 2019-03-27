<?php

/*
 * This file is part of the overtrue/laravel-options.
 *
 * (c) overtrue <anzhengchao@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Overtrue\LaravelOptions\Test;

use Illuminate\Support\Facades\Event;
use Overtrue\LaravelOptions\OptionsManager;

class FeaturesTest extends TestCase
{
    /** @test */
    public function it_can_get_instance()
    {
        $this->assertInstanceOf(OptionsManager::class, app('laravel-options'));
    }

    /** @test */
    public function it_can_set()
    {
        \Option::set(['foo' => 'bar', 'bar' => 'baz']);
        \Option::set('name', 'laravel-options');

        $this->assertDatabaseHas('options', ['key' => 'foo', 'value' => '"bar"']);
        $this->assertDatabaseHas('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseHas('options', ['key' => 'name', 'value' => '"laravel-options"']);
    }

    /** @test */
    public function it_will_trigger_events()
    {
        Event::fake();

        \Option::set('foo', 'bar');
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionCreated::class);
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionSaved::class);

        \Option::set('foo', 'new-value');
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionUpdated::class);
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionSaved::class);

        \Option::get('foo');
        \Option::all();
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionRetrieved::class, 3);

        \Option::remove('foo');
        Event::assertDispatched(\Overtrue\LaravelOptions\Events\OptionDeleted::class);
    }

    /** @test */
    public function it_can_get_default()
    {
        $this->assertSame('baz', \Option::get('foo', 'baz'));
    }

    /** @test */
    public function it_can_get()
    {
        \Option::set('foo', 'bar');

        $this->assertSame('bar', \Option::get('foo', 'baz'));
    }

    /** @test */
    public function it_can_check_if_exists()
    {
        $this->assertFalse(\Option::has('foo'));

        \Option::set('foo', 'bar');

        $this->assertTrue(\Option::has('foo'));
    }

    /** @test */
    public function it_can_remove()
    {
        \Option::set('foo', 'bar');
        \Option::set('bar', 'baz');
        \Option::set('name', 'overtrue');

        $this->assertDatabaseHas('options', ['key' => 'foo', 'value' => '"bar"']);
        $this->assertDatabaseHas('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseHas('options', ['key' => 'name', 'value' => '"overtrue"']);

        \Option::remove('foo');

        $this->assertDatabaseMissing('options', ['key' => 'foo', 'value' => 'bar']);

        \Option::remove(['bar', 'name']);
        $this->assertDatabaseMissing('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseMissing('options', ['key' => 'name', 'value' => '"overtrue"']);
    }

    /** @test */
    public function it_can_set_array_value()
    {
        \Option::set(['foo' => ['bar', 'baz']]);

        $this->assertSame(['bar', 'baz'], \Option::get('foo'));
    }

    /** @test */
    public function it_can_set_number_value()
    {
        \Option::set(['foo' => 123.45, 'bar' => 456, 'baz' => 0]);

        $this->assertSame(123.45, \Option::get('foo'));
        $this->assertSame(456, \Option::get('bar'));
        $this->assertSame(0, \Option::get('baz'));
    }

    /** @test */
    public function it_can_set_boolean_value()
    {
        \Option::set(['foo' => false, 'bar' => true]);

        $this->assertFalse(\Option::get('foo'));
        $this->assertTrue(\Option::get('bar'));
    }
}
