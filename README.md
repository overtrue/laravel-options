# Laravel Options

[![Build Status](https://img.shields.io/travis/overtrue/laravel-options/master.svg?style=flat-square)](https://travis-ci.org/overtrue/laravel-options)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/overtrue/laravel-options.svg?style=flat-square)](https://packagist.org/packages/overtrue/laravel-options)
[![Total Downloads](https://img.shields.io/packagist/dt/overtrue/laravel-options.svg?style=flat-square)](https://packagist.org/packages/overtrue/laravel-options)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Global options module for Laravel application.

## Installation

You can install the package via composer:

```bash
composer require overtrue/laravel-options -vvv
```

### Publish configuration and migrations

```bash
$ php artisan vendor:publish --provider="Overtrue\LaravelOptions\OptionsServiceProvider"
```

### Run migrations

```bash
$ php artisan migrate
```

## Usage

```php
// set
\Option::set('foo', 'bar');
\Option::set(['foo' => 'bar', 'bar' => 'baz']);

// get
\Option::get('foo'); // bar
\Option::get(['foo', 'bar']); // ['foo' => 'bar', 'bar' => 'baz']
\Option::getAll(['foo', 'bar']); // ['foo' => 'bar', 'bar' => 'baz']

// get all
\Option::get();
// or
\Option::getAll();

// check exists
\Option::has('foo'); // true

\Option::remove('foo'); 
\Option::remove(['foo', 'bar']);
```

### Console commands

It is also possible to set options within the console:

```bash
php artisan option:set {key} {value}
```

## Testing

```bash
$ composer test
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/overtrue/laravel-options/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/overtrue/laravel-options/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
