<?php

namespace Getecz\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        if (!file_exists(config('installer.installed_file'))) {

            // Allow installer routes without redirect loops
            if ($request->is('install') || $request->is('install/*')) {
                return $next($request);
            }

            return redirect()->route('installer.welcome');
        }

        return $next($request);
    }
}
