<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\profileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        // If profile doesn't exist, create a basic one
        if (!$profile) {
            $profile = profileModel::create([
                'user_id' => $user->id,
                'fullname' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'contact' => $user->contact,
            ]);
        }
        
        return view('profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'contact' => 'required|string|max:20|unique:users,contact,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'fullname' => 'required|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'id_type' => 'nullable|string',
            'id_no' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postoffice' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
        ];

        // Add farmer-specific fields if user is a farmer
        if ($user->hasRole('farmer')) {
            $rules = array_merge($rules, [
                'referred_by' => 'nullable|string|max:100',
                'crop_grown' => 'nullable|string',
                'land_area_cultivated' => 'nullable|string|max:50',
                'land_area_total' => 'nullable|string|max:50',
                'farming_since' => 'nullable|string|max:50',
                'technology_intervention' => 'nullable|string',
                'capital_investment' => 'nullable|string|max:50',
                'future_plans' => 'nullable|string',
                'info_on_all_crops' => 'nullable|string',
            ]);
        }

        $validated = $request->validate($rules);

        // Update User table
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->username = $validated['username'];
        $user->contact = $validated['contact'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        // Update or create Profile
        $profileData = [
            'user_id' => $user->id,
            'fullname' => $validated['fullname'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'gender' => $validated['gender'] ?? null,
            'id_type' => $validated['id_type'] ?? null,
            'id_no' => $validated['id_no'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'address' => $validated['address'] ?? null,
            'district' => $validated['district'] ?? null,
            'state' => $validated['state'] ?? null,
            'postoffice' => $validated['postoffice'] ?? null,
            'pincode' => $validated['pincode'] ?? null,
        ];

        // Handle WhatsApp (can be same as contact)
        if ($request->has('contact_same_as_whatsapp') && $request->contact_same_as_whatsapp) {
            $profileData['whatsapp'] = $validated['contact'];
        } else {
            $profileData['whatsapp'] = $validated['whatsapp'] ?? null;
        }

        // Add farmer-specific fields
        if ($user->hasRole('farmer')) {
            $profileData = array_merge($profileData, [
                'referred_by' => $validated['referred_by'] ?? null,
                'crop_grown' => $validated['crop_grown'] ?? null,
                'land_area_cultivated' => $validated['land_area_cultivated'] ?? null,
                'land_area_total' => $validated['land_area_total'] ?? null,
                'farming_since' => $validated['farming_since'] ?? null,
                'technology_intervention' => $validated['technology_intervention'] ?? null,
                'capital_investment' => $validated['capital_investment'] ?? null,
                'future_plans' => $validated['future_plans'] ?? null,
                'info_on_all_crops' => $validated['info_on_all_crops'] ?? null,
            ]);
        }

        if ($profile) {
            $profile->update($profileData);
        } else {
            profileModel::create($profileData);
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}

