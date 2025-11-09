<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoadUserRoles
{
    /**
     * Handle an incoming request.
     * Ensures user roles are loaded before role middleware checks.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Load roles to ensure they're available for middleware checks
            if ($user && !$user->relationLoaded('roles')) {
                $user->load('roles');
            }
        }

        return $next($request);
    }
}

