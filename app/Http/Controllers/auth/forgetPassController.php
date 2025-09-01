<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;


class forgetPassController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
        ]);

        // Find user by email, username, or contact
        // $user = User::where('email', $request->login)
        //     ->orWhere('username', $request->login)
        //     ->orWhere('contact', $request->login)
        //     ->first();


        $user = User::where('email', $request->login)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        // 🔹 Instead of sending email, redirect directly to reset page
        return redirect()->route('password.reset', ['email' => $user->email]);

        /*
        // ✅ Uncomment below if you later want to send reset email
        $status = Password::sendResetLink(['email' => $user->email]);
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Password reset link sent!')
            : back()->withErrors(['email' => 'Unable to send reset link.']);
        */
    }
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        // $request->validate([
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->password = Hash::make($password);
        //         $user->save();
        //     }
        // );

        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password changed successfully! You can now log in.');

        // return $status === Password::PASSWORD_RESET
        //     ? redirect()->route('login')->with('success', 'Password reset successful!')
        //     : back()->withErrors(['email' => 'Failed to reset password.']);
    }
}
