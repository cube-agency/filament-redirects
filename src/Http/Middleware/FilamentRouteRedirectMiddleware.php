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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $redirect = Redirect::query();

        $redirect->whereIn('from_url', [$request->url(), $request->path()]);
        $redirect->orWhere('from_url', 'LIKE', '_' . $request->path() . '_');

        $redirect = $redirect->first(['to_url', 'status']);

        if ($redirect) {
            return redirect($redirect->to_url, $redirect->status);
        }

        return $next($request);
    }
}
