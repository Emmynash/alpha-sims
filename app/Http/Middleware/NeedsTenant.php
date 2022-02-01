<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NeedsTenant extends \Spatie\Multitenancy\Http\Middleware\NeedsTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Skip this middleware whenever the landlord is requested.
        if (config('database.default') === 'landlord') {
            return $next($request);
        }

        // return $next($request);
        return parent::handle($request, $next);
    }
}
