# Laravel Options

Global options module for Laravel application.

![Laravel Octane Ready Status](https://img.shields.io/badge/Octance-ready-green?style=flat-square)
![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/overtrue/laravel-options?style=flat-square)
![GitHub License](https://img.shields.io/github/license/overtrue/laravel-options?style=flat-square)
![Packagist Downloads](https://img.shields.io/packagist/dt/overtrue/laravel-options?style=flat-square)

[![Sponsor me](https://github.com/overtrue/overtrue/blob/master/sponsor-me-button-s.svg?raw=true)](https://github.com/sponsors/overtrue)

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
\Option::all(['foo', 'bar']); // ['foo' => 'bar', 'bar' => 'baz']

// get all
\Option::get();
// or
\Option::all();

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

### Events

- `\Overtrue\LaravelOptions\Events\OptionCreated::class`
- `\Overtrue\LaravelOptions\Events\OptionUpdated::class`
- `\Overtrue\LaravelOptions\Events\OptionSaved::class`
- `\Overtrue\LaravelOptions\Events\OptionDeleted::class`
- `\Overtrue\LaravelOptions\Events\OptionRetrieved::class`
- `\Overtrue\LaravelOptions\Events\Event::class`

## Testing

```bash
$ composer test
```

## :heart: Sponsor me 

[![Sponsor me](https://github.com/overtrue/overtrue/blob/master/sponsor-me.svg?raw=true)](https://github.com/sponsors/overtrue)

如果你喜欢我的项目并想支持它，[点击这里 :heart:](https://github.com/sponsors/overtrue)

## Project supported by JetBrains

Many thanks to Jetbrains for kindly providing a license for me to work on this and other open-source projects.

[![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)](https://www.jetbrains.com/?from=https://github.com/overtrue)


## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/overtrue/laravel-options/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/overtrue/laravel-options/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注我的实战课程，我会在此课程中分享一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package)

## License

MIT
