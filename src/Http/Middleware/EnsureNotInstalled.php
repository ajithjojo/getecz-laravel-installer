<?php

namespace Getecz\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNotInstalled
{
    public function handle(Request $request, Closure $next)
    {
        if (file_exists(config('installer.installed_file'))) {
            abort(404);
        }

        return $next($request);
    }
}
