<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Http\Request;
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact' => ['required', 'digits:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        profileModel::create([
            'fullname' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
        ]);
        $user =User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('farmer');
        // Optionally, log the user in after registration
        // Auth::login($user);
        return redirect('/login')->with('success', 'Registration successful!');
    }
}
