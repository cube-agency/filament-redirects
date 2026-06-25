<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use CubeAgency\FilamentRedirects\Http\Middleware\FilamentRouteRedirectMiddleware;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Run a GET request for $uri through the middleware. The fallback $next
 * returns a sentinel 200 response so we can detect a pass-through.
 */
function handleThrough(string $uri)
{
    return (new FilamentRouteRedirectMiddleware)->handle(
        Request::create($uri),
        fn ($request) => response('passed-through', 200)
    );
}

it('redirects when the full url matches from_url', function () {
    Redirect::factory()->permanent()->create([
        'from_url' => 'http://localhost/promo',
        'to_url' => 'https://example.com/promo',
    ]);

    $response = handleThrough('http://localhost/promo');

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and($response->getTargetUrl())->toBe('https://example.com/promo')
        ->and($response->getStatusCode())->toBe(RedirectStatus::PERMANENT->value);
});

it('redirects when the path matches from_url', function () {
    Redirect::factory()->temporary()->create([
        'from_url' => 'promo',
        'to_url' => 'https://example.com/promo',
    ]);

    $response = handleThrough('http://localhost/promo');

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and($response->getTargetUrl())->toBe('https://example.com/promo')
        ->and($response->getStatusCode())->toBe(RedirectStatus::TEMPORARY->value);
});

it('passes the request through when nothing matches', function () {
    Redirect::factory()->create(['from_url' => 'something-else']);

    $response = handleThrough('http://localhost/no-match');

    expect($response)->not->toBeInstanceOf(RedirectResponse::class)
        ->and($response->getContent())->toBe('passed-through');
});

/*
 * `from_url` is matched exactly, tolerating an optional leading/trailing slash
 * on the stored value: '/promo', 'promo/' and '/promo/' all match the request
 * path 'promo'. This replaced an earlier `LIKE '_<path>_'` clause whose `_` is a
 * SQL single-character wildcard, which over-matched unrelated values.
 */
it('matches a from_url stored with surrounding slashes', function () {
    Redirect::factory()->permanent()->create([
        'from_url' => '/promo/',
        'to_url' => 'https://example.com/promo',
    ]);

    $response = handleThrough('http://localhost/promo');

    expect($response)->toBeInstanceOf(RedirectResponse::class)
        ->and($response->getTargetUrl())->toBe('https://example.com/promo');
});

it('matches a from_url stored with a leading or trailing slash', function (string $fromUrl) {
    Redirect::factory()->permanent()->create([
        'from_url' => $fromUrl,
        'to_url' => 'https://example.com/promo',
    ]);

    expect(handleThrough('http://localhost/promo'))
        ->toBeInstanceOf(RedirectResponse::class);
})->with(['/promo', 'promo/']);

it('does not over-match values that merely contain the path', function () {
    Redirect::factory()->temporary()->create([
        'from_url' => 'Xpromo7', // no longer matches now that the wildcard is gone
        'to_url' => 'https://example.com/promo',
    ]);

    $response = handleThrough('http://localhost/promo');

    expect($response)->not->toBeInstanceOf(RedirectResponse::class)
        ->and($response->getContent())->toBe('passed-through');
});
