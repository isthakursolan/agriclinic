<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class roleController extends Controller
{
    public function index()
    {
        // Exclude admin and superadmin
        $users = User::with('roles')
            ->whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['admin', 'superadmin']);
            })
            ->get();

        // $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.roles.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        // Prevent editing admins / superadmins
        if ($user->hasRole(['admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'You cannot change role of admin or superadmin');
        }

        $roles = Role::all();
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->hasRole(['admin', 'superadmin'])) {
            return redirect()->back()->with('error', 'You cannot change role of admin or superadmin');
        }

        // $request->validate([
        //     'role' => 'required|exists:roles,name',
        // ]);

         $request->validate([
            'role'   => 'required|array|min:1',
            'role.*' => 'exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.roles')->with('success', 'Roles updated successfully');
    }
}
