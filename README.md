# Filament plugin for redirect management

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cube-agency/filament-redirects.svg?style=flat-square)](https://packagist.org/packages/cube-agency/filament-redirects)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/cube-agency/filament-redirects/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/cube-agency/filament-redirects/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/cube-agency/filament-redirects/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/cube-agency/filament-redirects/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/cube-agency/filament-redirects.svg?style=flat-square)](https://packagist.org/packages/cube-agency/filament-redirects)

Adds redirect management functionality

## Installation

You can install the package via composer:

```bash
composer require cube-agency/filament-redirects
```

Run migrations:

```bash
php artisan migrate
```

Add the plugin to your panel provider:
```bash
use CubeAgency\FilamentRedirects\FilamentRedirectsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ...
        ->plugins([
            ...
            FilamentRedirectsPlugin::make()
        ]);
}
```

Register redirect middleware in bootstrap/app.php file:
```bash
use CubeAgency\FilamentRedirects\Http\Middleware\FilamentRouteRedirectMiddleware;

return Application::configure(...)
    ...
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(FilamentRouteRedirectMiddleware::class);
    })
    ...
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dmitrijs Mihailovs](https://github.com/cube-agency)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
