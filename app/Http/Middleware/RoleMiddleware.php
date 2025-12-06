<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles  Example: "admin|receptionist"
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        // Normalize roles and user role to avoid casing/whitespace mismatches
        $rolesArray = array_map(function ($r) {
            return trim(strtolower($r));
        }, explode('|', $roles));

        $userRole = trim(strtolower((string) $user->role));

        if (in_array($userRole, $rolesArray, true)) {
            return $next($request);
        }

        // If the request expects JSON, return a 403 response; otherwise redirect back with a message
        if ($request->expectsJson()) {
            abort(403, 'Unauthorized');
        }

        return redirect()->route('login')->with('error', 'You do not have permission to access that page.');
    }
}
