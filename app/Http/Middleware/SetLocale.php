<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: session > authenticated user preference > default
        $locale = session('locale');

        if (!$locale && $request->user()) {
            $locale = $request->user()->locale;
        }

        $supportedLocales = ['en', 'fr', 'es', 'de', 'zh'];
        if ($locale && in_array($locale, $supportedLocales)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
