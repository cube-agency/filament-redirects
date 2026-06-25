<?php

namespace CubeAgency\FilamentRedirects\Tests;

use CubeAgency\FilamentRedirects\FilamentRedirectsPlugin;
use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->plugin(FilamentRedirectsPlugin::make());
    }
}
