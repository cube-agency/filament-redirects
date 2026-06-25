<?php

namespace CubeAgency\FilamentRedirects\Http\Middleware;

use Closure;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentRouteRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $trimmed = trim($path, '/');

        // Match `from_url` exactly against the full URL or the request path
        $candidates = array_unique(array_merge(
            [$request->url(), $path],
            $trimmed === '' ? [] : ['/' . $trimmed, $trimmed . '/', '/' . $trimmed . '/'],
        ));

        $redirect = Redirect::query()
            ->whereIn('from_url', $candidates)
            ->first(['to_url', 'status']);

        if ($redirect) {
            return redirect($redirect->to_url, $redirect->status);
        }

        return $next($request);
    }
}
