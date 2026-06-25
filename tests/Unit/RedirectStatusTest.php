<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;

it('exposes the http status codes as backing values', function () {
    expect(RedirectStatus::PERMANENT->value)->toBe(301)
        ->and(RedirectStatus::TEMPORARY->value)->toBe(302);
});

it('builds a select array keyed by status code with translated labels', function () {
    $options = RedirectStatus::asSelectArray();

    // Keyed by backing value, in enum declaration order (TEMPORARY, PERMANENT).
    expect($options)->toEqual([
        302 => 'Temporary',
        301 => 'Permanent',
    ]);
});
