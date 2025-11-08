<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    // public function index()
    // {
    //     if (Auth::check()) {
    //         $user = Auth::user();

    //         // Redirect based on role
    //         if ($user->hasRole(['admin', 'superadmin'])) {
    //             return redirect()->route('admin.dashboard');
    //         }
    //         if ($user->hasRole('consultant')) {
    //             return redirect()->route('con.dashboard');
    //         }
    //         if ($user->hasRole('lab_scientist')) {
    //             return redirect()->route('lab.dashboard');
    //         }
    //         if ($user->hasRole('analyst')) {
    //             return redirect()->route('analyst.dashboard');
    //         }
    //         if ($user->hasRole('accountant')) {
    //             return redirect()->route('acc.dashboard');
    //         }
    //         if ($user->hasRole('field_agent')) {
    //             return redirect()->route('agent.dashboard');
    //         }
    //         if ($user->hasRole('front_office')) {
    //             return redirect()->route('front.dashboard');
    //         }
    //         if ($user->hasRole('farmer')) {
    //             return redirect()->route('user.dashboard');
    //         }
    //     }

    //     // If not logged in → show login form
    //     return view('auth.login');
    // }

    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect('/login')->with('success', 'Logged out successfully.');
    // }
    public function index()
    {
        return view('auth.login'); // Guest middleware ensures only logged-out users see this
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        // Find the user by email, username, or contact
        $loginInput = $request->email;
        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->orWhere('contact', $loginInput)
            ->first();
        
        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            $user = Auth::user();
            $profile = profileModel::where('user_id', $user->id)->first();
            if ($profile) {
                $request->session()->put(['id' => $profile->id]);
            }
            // Route to role-specific views or reuse one view with conditional widgets
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

                // return view('dashboards.farmer', compact('user'));
                return redirect()->route('user.dashboard');
                // return view('farmer.dashboard', [
                //     'plots_count' => Plot::where('farmer_id', $user->id)->count(),
                //     'crops_count' => Crop::where('farmer_id', $user->id)->count(),
                //     'tests_count' => TestCase::where('farmer_id', $user->id)->count(),
                //     'pending_payments' => Payment::where('farmer_id', $user->id)->where('status', 'pending')->count(),
                // ]);
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
