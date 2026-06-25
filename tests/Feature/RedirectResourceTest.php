<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\CreateRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\EditRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\ListRedirects;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

it('renders the list page', function () {
    Livewire::test(ListRedirects::class)->assertStatus(200);
});

it('lists existing redirects', function () {
    $redirect = Redirect::factory()->create();

    Livewire::test(ListRedirects::class)
        ->assertStatus(200)
        ->assertCanSeeTableRecords([$redirect])
        ->assertSee($redirect->from_url);
});

it('can create a redirect', function () {
    Livewire::test(CreateRedirect::class)
        ->fillForm([
            'from_url' => 'old-path',
            'to_url' => 'https://example.com/new',
            'status' => RedirectStatus::PERMANENT->value,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Redirect::class, [
        'from_url' => 'old-path',
        'to_url' => 'https://example.com/new',
        'status' => RedirectStatus::PERMANENT->value,
    ]);
});

it('validates that from_url and to_url are required', function () {
    Livewire::test(CreateRedirect::class)
        ->fillForm([
            'from_url' => null,
            'to_url' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['from_url', 'to_url']);
});

it('can edit a redirect', function () {
    $redirect = Redirect::factory()->create();

    Livewire::test(EditRedirect::class, ['record' => $redirect->getRouteKey()])
        ->fillForm(['to_url' => 'https://example.com/updated'])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Redirect::class, [
        'id' => $redirect->id,
        'to_url' => 'https://example.com/updated',
    ]);
});

it('can delete a redirect from the edit page', function () {
    $redirect = Redirect::factory()->create();

    Livewire::test(EditRedirect::class, ['record' => $redirect->getRouteKey()])
        ->callAction('delete');

    assertDatabaseMissing(Redirect::class, ['id' => $redirect->id]);
});

it('filters the table by status', function () {
    $permanent = Redirect::factory()->permanent()->create();
    $temporary = Redirect::factory()->temporary()->create();

    Livewire::test(ListRedirects::class)
        ->filterTable('status', RedirectStatus::PERMANENT->value)
        ->assertCanSeeTableRecords([$permanent])
        ->assertCanNotSeeTableRecords([$temporary]);
});
