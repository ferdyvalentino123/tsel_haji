<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureSupervisor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check() && in_array(Auth::user()->role, ['supervisor', 'admin'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}