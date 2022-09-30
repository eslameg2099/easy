<?php

namespace App\Http\Middleware;

use Closure;

class DelegateApprovedMiddleware
{
    /**
     * The URIs that should be excluded from delegate approval.
     *
     * @var array
     */
    protected $except = [
        '/api/verification/*',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (
            auth()->check() &&
            $user->isDelegate() &&
            ! $user->is_approved &&
            ! $this->inExceptArray($request)
        ) {
            abort(403, __('Your account does not approve yet'));
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should pass through delegate approval.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
