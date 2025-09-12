<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\profileModel;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = User::role('farmer')->with('profile')->get();
        return view('frontoffice.farmers.index', compact('farmers'));
    }

    public function create()
    {
        return view('frontoffice.farmers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'contact'  => 'required',
        ]);

        // Create user
        $user = User::create([
            'name'     => $request->fullname,
            'username' => $request->username,
            'email'    => $request->email,
            'contact'  => $request->contact,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('farmer');

        // Create profile
        profileModel::create([
            'user_id'   => $user->id,
            'fullname'  => $request->fullname,
            'username'  => $request->username,
            'email'     => $request->email,
            'contact'   => $request->contact,
            'whatsapp'  => $request->whatsapp,
            'gender' => $request->gender,
            'id_type' => $request->id_type,
            'id_no' => $request->id_no,
            'address'   => $request->address,
            'district'  => $request->district,
            'state'     => $request->state,
            'pincode'   => $request->pincode,
            'postoffice' => $request->postoffice,
            'referred_by' => $request->referred_by,
            'crop_grown' => $request->crop_grown,
            'land_area_cultivated' => $request->land_area_cultivated,
            'land_area_total' => $request->land_area_total,
            'farming_since' => $request->farming_since,
            'technology_intervention' => $request->technology_intervention,
            'capital_investment' => $request->capital_investment,
            'future_plans' => $request->future_plans,
            'info_on_all_crops' => $request->info_on_all_crops,
        ]);

        return redirect()->route('frontoffice.farmers.index')->with('success', 'Farmer created successfully');
    }

    public function edit($id)
    {
        $farmer = User::with('profile')->findOrFail($id);
        return view('frontoffice.farmers.edit', compact('farmer'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $profile = $user->profile;

        // Validation
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact' => 'required|string|max:20|unique:users,contact,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        // Update User table
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact = $request->contact;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update Profile table
        $profileData = $request->only([
            'fullname', 'whatsapp', 'gender', 'id_type', 'id_no', 'address', 'district',
            'state', 'pincode', 'postoffice', 'referred_by', 'crop_grown', 'land_area_cultivated',
            'land_area_total', 'farming_since', 'technology_intervention', 'capital_investment',
            'future_plans', 'info_on_all_crops'
        ]);

        if ($request->has('contact_same_as_whatsapp')) {
            $profileData['whatsapp'] = $request->contact;
        }

        if ($profile) {
            $profile->update($profileData);
        } else {
            $profileData['user_id'] = $user->id;
            profileModel::create($profileData);
        }

        return redirect()->route('frontoffice.farmers.index')
            ->with('success', 'Farmer updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile) {
            $user->profile->delete();
        }
        $user->delete();

        return redirect()->route('frontoffice.farmers.index')->with('success', 'Farmer deleted successfully!');
    }
}

