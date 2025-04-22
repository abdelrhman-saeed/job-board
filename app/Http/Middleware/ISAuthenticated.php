<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ISAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth('company')->check() && ! auth('candidate')->check()) {
            return response()->json(['message' => 'unauthenticated'], 403);
        }

        auth()->setUser(auth('company')->user() ?? auth('candidate')->user());
        return $next($request);
    }
}
