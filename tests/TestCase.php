<?php

namespace CubeAgency\FilamentRedirects\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use CubeAgency\FilamentRedirects\FilamentRedirectsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'CubeAgency\\FilamentRedirects\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            NotificationsServiceProvider::class,
            SchemasServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            AdminPanelProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentRedirectsServiceProvider::class,
            // Registered last on purpose: Livewire's mechanism registration resolves
            // app(DataStore::class) — by now bound to Filament's DataStoreOverride — and
            // pins it as the shared instance. If Livewire registered first, Filament's
            // later non-shared bind() would leave DataStore resolving fresh on every call
            // and Livewire's per-component error bag would come back null during renders.
            LivewireServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('app.key', 'base64:j4TkRHy8hbJCJ255PmYRqn5pvxrhf3QKvJcrBj0M/gY=');
        config()->set('database.default', 'testing');
        config()->set('filament-redirects.table_name', 'filament_redirects');

        $migration = include __DIR__ . '/../database/migrations/create_filament_redirects_table.php.stub';
        $migration->up();
    }
}
