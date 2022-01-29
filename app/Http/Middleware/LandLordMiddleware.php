<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandLordMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getHost() === config('app.domain')) {

            // if Host is 'laravel.test' set DB connection to 'landlord'
            config(['database.default' => 'landlord']);

            return $next($request);
        } else {
            return $next($request);
        }
    }
}
