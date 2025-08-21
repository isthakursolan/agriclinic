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
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $profile = profileModel::where('email', $user->email)->first();
            $request->session()->put(['id'=> $profile->id]);
            // Route to role-specific views or reuse one view with conditional widgets
            if ($user->hasRole(['admin', 'superadmin'])) {
                // return view('dashboards.admin', compact('user'));
                return redirect()->route('admin.dashboard');
            }
            if ($user->hasRole('consultant')) {
                return view('dashboards.consultant', compact('user'));
            }
            if ($user->hasRole('lab_scientist') || $user->hasRole('analyst')) {
                return view('dashboards.lab', compact('user'));
            }
            if ($user->hasRole('accountant')) {
                return view('dashboards.accountant', compact('user'));
            }
            if ($user->hasRole('field_agent')) {
                return view('dashboards.agent', compact('user'));
            }
            if ($user->hasRole('front_office')) {
                return view('dashboards.frontoffice', compact('user'));
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
        return redirect('/login');
    }
}
