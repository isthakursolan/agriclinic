<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact' => ['required', 'digits:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::beginTransaction();

        try {
            // Create user only for login
            // Create user in users table
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'contact' => $request->contact,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('farmer'); // if you use roles

            // Create profile with user_id relation
            profileModel::create([
                'user_id' => $user->id,   // <-- link profile to user
                'fullname' => $request->name,
                'username' => $request->username,
                'contact' => $request->contact,
                'email' => $request->email, // optional if you want it here too
                // add more profile fields (address, dob, gender, etc.)
            ]);

            DB::commit();

            // Auto-login farmer after registration
            // Auth::login($user);

            return redirect()->route('login')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }
}
