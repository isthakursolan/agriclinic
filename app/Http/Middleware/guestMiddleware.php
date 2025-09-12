<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class guestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // redirect to role-based dashboards
            if ($user->hasRole(['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('consultant')) {
                return redirect()->route('con.dashboard');
            }
            if ($user->hasRole('lab_scientist')) {
                return redirect()->route('lab.dashboard');
            }
            if ($user->hasRole('analyst')) {
                return redirect()->route('analyst.dashboard');
            }
            if ($user->hasRole('accountant')) {
                return redirect()->route('acc.dashboard');
            }
            if ($user->hasRole('field_agent')) {
                return redirect()->route('agent.dashboard');
            }
            if ($user->hasRole('front_office')) {
                return redirect()->route('frontoffice.dashboard');
            }
            if ($user->hasRole('farmer')) {
                return redirect()->route('user.dashboard');
            }
        }

        // if not logged in, continue to login/register page
        return $next($request);
    }
}
