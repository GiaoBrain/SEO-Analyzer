<?php

namespace App\Http\Middleware;

use Closure;

class InstalledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the app has been installed
        // This prevents doing any SQL queries to the database, before the app has been installed
        if (file_exists(storage_path('installed'))) {
            return $next($request);
        }

        return redirect()->route('install');
    }
}
