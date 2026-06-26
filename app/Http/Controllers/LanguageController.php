<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the application locale.
     */
    public function switch(Request $request, string $locale)
    {
        $supportedLocales = ['en', 'fr', 'es', 'de', 'zh'];

        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }

        session(['locale' => $locale]);

        // Update user preference if authenticated
        if ($request->user()) {
            $request->user()->update(['locale' => $locale]);
        }

        return back();
    }
}
