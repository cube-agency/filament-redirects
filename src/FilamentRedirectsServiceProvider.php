<?php

namespace CubeAgency\FilamentRedirects;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentRedirectsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-redirects';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishMigrations()
                    ->askToRunMigrations();
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }
    }

    public function packageRegistered(): void
    {
    }

    protected function getMigrations(): array
    {
        return [
            'create_filament_redirects_table',
        ];
    }
}
