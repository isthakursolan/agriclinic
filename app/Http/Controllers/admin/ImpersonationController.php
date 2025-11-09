<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\profileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Display a listing of all users.
     * Only accessible by superadmin.
     */
    public function index()
    {
        // Ensure only superadmin can access
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized access.');
        }

        $users = User::with('roles', 'profile')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user's profile.
     * Only accessible by superadmin.
     */
    public function show(User $user)
    {
        // Ensure only superadmin can access
        if (!Auth::user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized access.');
        }

        // Load user relationships
        $user->load('roles', 'profile');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Start impersonating a user.
     * Only accessible by superadmin.
     */
    public function impersonate(Request $request, User $user)
    {
        $currentUser = Auth::user();

        // Ensure only superadmin can impersonate
        if (!$currentUser->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Only superadmin can impersonate users.');
        }

        // Prevent impersonating another superadmin
        if ($user->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Cannot impersonate another superadmin.');
        }

        // Prevent impersonating yourself
        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'Cannot impersonate yourself.');
        }

        // Store original user ID in session BEFORE login (to preserve it)
        $request->session()->put('impersonation.original_user_id', $currentUser->id);
        $request->session()->put('impersonation.impersonated_user_id', $user->id);
        $request->session()->put('impersonation.started_at', now());

        // Log in as the impersonated user (this may regenerate session, so we'll restore data after)
        Auth::loginUsingId($user->id, true); // true = remember the user
        
        // Re-store impersonation data after login (session might have been regenerated)
        $request->session()->put('impersonation.original_user_id', $currentUser->id);
        $request->session()->put('impersonation.impersonated_user_id', $user->id);
        $request->session()->put('impersonation.started_at', now());

        // Update profile session if exists
        $profile = profileModel::where('user_id', $user->id)->first();
        if ($profile) {
            $request->session()->put('id', $profile->id);
        }

        // Redirect to appropriate dashboard based on user's role
        if ($user->hasRole(['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('consultant')) {
            return redirect()->route('con.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('lab_scientist')) {
            return redirect()->route('lab.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('analyst')) {
            return redirect()->route('analyst.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('accountant')) {
            return redirect()->route('acc.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('field_agent')) {
            return redirect()->route('agent.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('front_office')) {
            return redirect()->route('frontoffice.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }
        if ($user->hasRole('farmer')) {
            return redirect()->route('user.dashboard')
                ->with('success', "Now impersonating as {$user->name}");
        }

        // Default redirect
        return redirect()->route('admin.dashboard')
            ->with('success', "Now impersonating as {$user->name}");
    }

    /**
     * Stop impersonating and return to original superadmin account.
     * This route is accessible even when impersonating (no role middleware).
     */
    public function stop(Request $request)
    {
        // Check if impersonating
        if (!$request->session()->has('impersonation.original_user_id')) {
            // If not impersonating, redirect based on user's role
            $user = Auth::user();
            if ($user && $user->hasRole(['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'You are not currently impersonating any user.');
            }
            return redirect()->route('login')
                ->with('error', 'You are not currently impersonating any user.');
        }

        // Get original user ID
        $originalUserId = $request->session()->get('impersonation.original_user_id');

        // Restore original user session
        Auth::loginUsingId($originalUserId, true);

        // Update profile session if exists
        $originalUser = User::find($originalUserId);
        if ($originalUser) {
            $profile = profileModel::where('user_id', $originalUser->id)->first();
            if ($profile) {
                $request->session()->put('id', $profile->id);
            }
        }

        // Clear impersonation session data
        $request->session()->forget('impersonation');

        return redirect()->route('admin.dashboard')
            ->with('success', 'Impersonation stopped. Returned to your account.');
    }
}

