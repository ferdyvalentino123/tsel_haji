<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route("login");
        }

        $user = auth()->user();
        $userRole = $user->role;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, "User does not have the right roles.");
    }
}
