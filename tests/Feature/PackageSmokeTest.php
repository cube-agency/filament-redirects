<?php

use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource;
use CubeAgency\FilamentRedirects\FilamentRedirectsPlugin;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Illuminate\Support\Facades\Schema;

it('merges the package config', function () {
    expect(config('filament-redirects.table_name'))->toBe('filament_redirects');
});

it('creates the redirects table from the migration', function () {
    expect(Schema::hasTable('filament_redirects'))->toBeTrue()
        ->and(Schema::hasColumns('filament_redirects', ['from_url', 'to_url', 'status']))->toBeTrue();
});

it('exposes a plugin with the expected id', function () {
    expect(FilamentRedirectsPlugin::make()->getId())->toBe('filament-redirects');
});

it('points the resource at the redirect model', function () {
    expect(RedirectResource::getModel())->toBe(Redirect::class);
});
