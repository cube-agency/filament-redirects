<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use CubeAgency\FilamentRedirects\Models\Redirect;

it('uses the configured table name', function () {
    config()->set('filament-redirects.table_name', 'custom_redirects');

    expect((new Redirect)->getTable())->toBe('custom_redirects');
});

it('resolves the status label from the enum', function () {
    $permanent = new Redirect(['status' => RedirectStatus::PERMANENT->value]);
    $temporary = new Redirect(['status' => RedirectStatus::TEMPORARY->value]);

    expect($permanent->status_label)->toBe('Permanent')
        ->and($temporary->status_label)->toBe('Temporary');
});

it('returns null label for an unknown status', function () {
    $redirect = new Redirect(['status' => 418]);

    expect($redirect->status_label)->toBeNull();
});

it('mass assigns the expected attributes', function () {
    $redirect = Redirect::create([
        'from_url' => 'old',
        'to_url' => 'https://example.com/new',
        'status' => RedirectStatus::PERMANENT->value,
    ]);

    expect($redirect->refresh())
        ->from_url->toBe('old')
        ->to_url->toBe('https://example.com/new')
        ->status->toBe(RedirectStatus::PERMANENT->value);
});
