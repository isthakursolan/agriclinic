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
        $currentUser = Auth::user();
        
        // Ensure only superadmin can access - load roles first
        if (!$currentUser) {
            abort(403, 'Unauthorized access.');
        }
        
        $currentUser->load('roles');
        if (!$currentUser->hasRole('superadmin')) {
            abort(403, 'Unauthorized access. Only superadmin can view all users.');
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
        $currentUser = Auth::user();
        
        // Ensure only superadmin can access - load roles first
        if (!$currentUser) {
            abort(403, 'Unauthorized access.');
        }
        
        $currentUser->load('roles');
        if (!$currentUser->hasRole('superadmin')) {
            abort(403, 'Unauthorized access. Only superadmin can view user profiles.');
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

        // Ensure only superadmin can impersonate - load roles first
        if (!$currentUser) {
            return redirect()->back()->with('error', 'You must be logged in to impersonate users.');
        }
        
        $currentUser->load('roles');
        if (!$currentUser->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Only superadmin can impersonate users.');
        }

        // Load user roles to check if they're a superadmin
        $user->load('roles');
        
        // Prevent impersonating another superadmin
        if ($user->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Cannot impersonate another superadmin.');
        }

        // Prevent impersonating yourself
        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'Cannot impersonate yourself.');
        }

        // Get fresh user instance with roles loaded
        $impersonatedUser = User::with('roles')->find($user->id);
        
        if (!$impersonatedUser) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Store original user ID in session BEFORE login (to preserve it)
        $originalUserId = $currentUser->id;
        
        // Log in as the impersonated user using the user model directly
        // This ensures the user instance with roles is properly set
        Auth::login($impersonatedUser, true); // true = remember the user
        
        // Re-store impersonation data after login (session might have been regenerated)
        $request->session()->put('impersonation.original_user_id', $originalUserId);
        $request->session()->put('impersonation.impersonated_user_id', $impersonatedUser->id);
        $request->session()->put('impersonation.started_at', now());

        // Update profile session if exists
        $profile = profileModel::where('user_id', $impersonatedUser->id)->first();
        if ($profile) {
            $request->session()->put('id', $profile->id);
        }

        // Save session to ensure it's persisted
        $request->session()->save();

        // Redirect to appropriate dashboard based on user's role
        if ($impersonatedUser->hasRole('admin')) {
            return redirect()->route('admin.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('consultant')) {
            return redirect()->route('con.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('lab_scientist')) {
            return redirect()->route('lab.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('analyst')) {
            return redirect()->route('analyst.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('accountant')) {
            return redirect()->route('acc.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('field_agent')) {
            return redirect()->route('agent.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('front_office')) {
            return redirect()->route('frontoffice.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }
        if ($impersonatedUser->hasRole('farmer')) {
            return redirect()->route('user.dashboard')
                ->with('success', "Now impersonating as {$impersonatedUser->name}");
        }

        // Default redirect
        return redirect()->route('admin.dashboard')
            ->with('success', "Now impersonating as {$impersonatedUser->name}");
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
            if ($user) {
                $user->load('roles');
                if ($user->hasRole('superadmin')) {
                    return redirect()->route('admin.users.index')
                        ->with('error', 'You are not currently impersonating any user.');
                }
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'You are not currently impersonating any user.');
                }
            }
            return redirect()->route('login')
                ->with('error', 'You are not currently impersonating any user.');
        }

        // Get original user ID
        $originalUserId = $request->session()->get('impersonation.original_user_id');

        // Restore original user session
        Auth::loginUsingId($originalUserId, true);
        
        // Get fresh user instance with roles loaded from database
        $originalUser = User::with('roles')->find($originalUserId);
        
        // Ensure the authenticated user has roles loaded
        if (Auth::user()) {
            Auth::user()->load('roles');
        }
        
        // Save session to ensure it's persisted
        $request->session()->save();

        // Update profile session if exists
        if ($originalUser) {
            $profile = profileModel::where('user_id', $originalUser->id)->first();
            if ($profile) {
                $request->session()->put('id', $profile->id);
            }
        }

        // Clear impersonation session data
        $request->session()->forget('impersonation');

        // Redirect based on original user's role
        if ($originalUser && $originalUser->hasRole('superadmin')) {
            return redirect()->route('admin.users.index')
                ->with('success', 'Impersonation stopped. Returned to your account.');
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Impersonation stopped. Returned to your account.');
    }
}

