<?php

namespace Overtrue\LaravelOptions\Test;

use Illuminate\Support\Facades\Event;
use Overtrue\LaravelOptions\Events\OptionCreated;
use Overtrue\LaravelOptions\Events\OptionDeleted;
use Overtrue\LaravelOptions\Events\OptionRetrieved;
use Overtrue\LaravelOptions\Events\OptionSaved;
use Overtrue\LaravelOptions\Events\OptionUpdated;
use Overtrue\LaravelOptions\OptionsManager;

class FeaturesTest extends TestCase
{
    public function test_it_can_get_instance()
    {
        $this->assertInstanceOf(OptionsManager::class, app('laravel-options'));
    }

    public function test_it_can_set()
    {
        \Option::set(['foo' => 'bar', 'bar' => 'baz']);
        \Option::set('name', 'laravel-options');

        $this->assertDatabaseHas('options', ['key' => 'foo', 'value' => '"bar"']);
        $this->assertDatabaseHas('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseHas('options', ['key' => 'name', 'value' => '"laravel-options"']);
    }

    public function test_it_will_trigger_events()
    {
        Event::fake();

        \Option::set('foo', 'bar');
        Event::assertDispatched(OptionCreated::class);
        Event::assertDispatched(OptionSaved::class);

        \Option::set('foo', 'new-value');
        Event::assertDispatched(OptionUpdated::class);
        Event::assertDispatched(OptionSaved::class);

        \Option::get('foo');
        \Option::all();
        Event::assertDispatched(OptionRetrieved::class, 3);

        \Option::remove('foo');
        Event::assertDispatched(OptionDeleted::class);
    }

    public function test_it_can_get_default()
    {
        $this->assertSame('baz', \Option::get('foo', 'baz'));
    }

    public function test_it_can_get()
    {
        \Option::set('foo', 'bar');

        $this->assertSame('bar', \Option::get('foo', 'baz'));
    }

    public function test_it_can_check_if_exists()
    {
        $this->assertFalse(\Option::has('foo'));

        \Option::set('foo', 'bar');

        $this->assertTrue(\Option::has('foo'));
    }

    public function test_it_can_remove()
    {
        \Option::set('foo', 'bar');
        \Option::set('bar', 'baz');
        \Option::set('name', 'overtrue');

        $this->assertDatabaseHas('options', ['key' => 'foo', 'value' => '"bar"']);
        $this->assertDatabaseHas('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseHas('options', ['key' => 'name', 'value' => '"overtrue"']);

        \Option::remove('foo');

        $this->assertDatabaseMissing('options', ['key' => 'foo']);
        $this->assertFalse(\Option::has('foo'));

        \Option::remove(['bar', 'name']);
        $this->assertDatabaseMissing('options', ['key' => 'bar', 'value' => '"baz"']);
        $this->assertDatabaseMissing('options', ['key' => 'name', 'value' => '"overtrue"']);
    }

    public function test_it_can_set_array_value()
    {
        \Option::set(['foo' => ['bar', 'baz']]);

        $this->assertSame(['bar', 'baz'], \Option::get('foo'));
    }

    public function test_it_can_set_number_value()
    {
        \Option::set(['foo' => 123.45, 'bar' => 456, 'baz' => 0]);

        $this->assertSame(123.45, \Option::get('foo'));
        $this->assertSame(456, \Option::get('bar'));
        $this->assertSame(0, \Option::get('baz'));
    }

    public function test_it_can_set_boolean_value()
    {
        \Option::set(['foo' => false, 'bar' => true]);

        $this->assertFalse(\Option::get('foo'));
        $this->assertTrue(\Option::get('bar'));
    }

    public function test_it_can_get_all_without_arguments()
    {
        \Option::set(['foo' => 'bar', 'enabled' => false]);

        $this->assertSame(['foo' => 'bar', 'enabled' => false], \Option::get());
        $this->assertSame(\Option::all(), \Option::get());
    }

    public function test_it_can_get_a_zero_key()
    {
        \Option::set('0', 'zero');

        $this->assertSame('zero', \Option::get('0'));
        $this->assertSame('zero', \Option::get(0));
    }

    public function test_it_can_get_selected_options()
    {
        \Option::set(['foo' => 'bar', 'number' => 42, 'ignored' => true]);

        $this->assertSame(['foo' => 'bar', 'number' => 42], \Option::get(['foo', 'number']));
        $this->assertSame(['number' => 42], \Option::all(['number', 'missing']));
        $this->assertSame(\Option::all(), \Option::get([]));
    }

    public function test_it_updates_an_option_without_creating_duplicates()
    {
        \Option::set('foo', 'first');
        \Option::set('foo', ['nested' => ['value' => 'second']]);

        $this->assertSame(['nested' => ['value' => 'second']], \Option::get('foo'));
        $this->assertDatabaseCount('options', 1);
    }

    public function test_it_preserves_null_and_default_value_behavior()
    {
        \Option::set('nullable', null);

        $this->assertTrue(\Option::has('nullable'));
        $this->assertSame(['nullable' => null], \Option::all());
        $this->assertSame('fallback', \Option::get('nullable', 'fallback'));
        $this->assertSame('fallback', \Option::get('missing', 'fallback'));
        $this->assertDatabaseCount('options', 1);
    }

    public function test_it_can_remove_a_missing_option()
    {
        \Option::set('kept', 'value');
        \Option::remove('missing');

        $this->assertSame(['kept' => 'value'], \Option::all());
    }

    public function test_it_can_set_an_option_from_the_console()
    {
        $this->artisan('option:set', ['key' => 'site.name', 'value' => 'Laravel 13'])
            ->expectsOutput('Option updated.')
            ->assertSuccessful();

        $this->assertSame('Laravel 13', \Option::get('site.name'));
    }

    public function test_it_reuses_the_provider_within_a_manager()
    {
        $manager = app('laravel-options');

        $this->assertSame('eloquent', $manager->getDefaultProvider());
        $this->assertSame($manager->provider(), $manager->provider('eloquent'));
        $this->assertSame($manager->provider(), $manager->provider(null));
    }

    public function test_it_supports_custom_providers()
    {
        config(['options.providers.custom' => ['driver' => 'custom']]);
        $manager = app('laravel-options');
        $provider = $manager->provider();
        $calls = 0;
        $manager->extend('custom', function ($app, $config) use ($provider, &$calls) {
            $this->assertSame($this->app, $app);
            $this->assertSame(['driver' => 'custom'], $config);
            $calls++;

            return $provider;
        });
        $manager->setDefaultProvider('custom');
        $manager->set('foo', 'bar');

        $this->assertSame('bar', $manager->get('foo'));
        $this->assertSame($provider, $manager->provider());
        $this->assertSame(1, $calls);
    }
}
