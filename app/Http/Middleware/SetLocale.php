<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $fallback = config('app.locale', 'en');
        $supported = config('app.supported_locales', ['en']);
        $current = $request->session()->get('locale', $fallback);

        $requested = $request->query('lang');
        if ($requested && in_array($requested, $supported, true)) {
            $current = $requested;
            $request->session()->put('locale', $current);
        }

        App::setLocale(in_array($current, $supported, true) ? $current : $fallback);

        return $next($request);
    }
}
