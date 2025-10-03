<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class CustomAuthMiddleware extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            $intendedUrl = $request->url();
            \Illuminate\Support\Facades\Log::info('Intended URL set in middleware: ' . $intendedUrl . "\n" . 'from route: ' . $request->route()->getName());
            session(['url.intended' => $intendedUrl]);
            return route('login');
        }
        return null;
    }
}
