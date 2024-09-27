<?php

namespace App\Http\Middleware;

use Closure;

class CronjobMiddleware
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
        // Set the maximum execution time up to a day
        ini_set('max_execution_time', 86400);

        // If the cronjob key is not valid
        if ($request->input('key') != config('settings.cronjob_key')) {
            abort(403);
        }

        return $next($request);
    }
}
