# Upgrading to 4.0

## Requirements

- PHP 8.3 or newer.
- Laravel 13.x (`^13.0`). Laravel 9, 10, 11, and 12 are not supported by this release.
- Package contributors now use Orchestra Testbench 11 and PHPUnit 12.5.

Dropping the older runtime versions is a breaking compatibility change, so this release is **4.0.0**, following 3.2.0.

## Application upgrade

1. Upgrade your application to PHP 8.3+ and Laravel 13 using the [Laravel upgrade guide](https://laravel.com/docs/13.x/upgrade).
2. Update the package constraint:

   ```bash
   composer require overtrue/laravel-options:^4.0 --with-all-dependencies
   ```

3. Run your application's tests, including option reads/writes and any custom option providers.

Existing option records, configuration, facade methods, custom provider contracts, console commands, and event classes remain compatible. No package database schema changes or republishing of existing migrations are required. New installations should publish and run the migrations as documented in the README.

## Corrected reads

- `Option::get()` now returns all options as documented, instead of passing `null` to an array-only provider method.
- `Option::get('0')` and `Option::get(0)` correctly read the `0` key instead of treating it as a request for all options.
- `OptionsManager::provider()` explicitly declares its nullable argument to avoid PHP 8.4 deprecations; accepted values are unchanged.

The existing behavior of returning the supplied default when a stored option value is `null` is unchanged.

## Contributor validation

```bash
composer update
composer validate --strict
composer test
composer check-style
composer audit
```

CI tests PHP 8.3, 8.4, and 8.5 with current dependencies, plus PHP 8.3 with the lowest dependencies that Composer can install securely. Security-advisory blocking remains enabled; the lowest job intentionally does not install versions blocked by current advisories.
