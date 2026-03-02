<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use symfony\Component\HttpFoundation\Response;

class userAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (auth()->user()->role != $role) {
            abort(403);//forbidden;
        }

        return $next($request);
    }
}