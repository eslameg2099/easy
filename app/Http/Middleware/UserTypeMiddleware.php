<?php

namespace App\Http\Middleware;

use Closure;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string[] $types
     * @return mixed
     */
    public function handle($request, Closure $next, ...$types)
    {
        if (! auth()->check() || ! in_array(auth()->user()->type, $types)) {
            abort(403);
        }

        return $next($request);
    }
}
