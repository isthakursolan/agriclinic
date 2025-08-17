<?php

namespace App\Http\Controllers;

use App\Models\ac_cropModel;
use App\Models\fieldModel;
use App\Models\profileModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class farmerController extends Controller
{
    public function index()
    {
        return view('farmer.dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    public function profileForm()
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $profile = profileModel::where('email', $user->email)->first();
        return view('farmer.profile', compact('profile'));
    }

    public function profileStore(Request $request, $id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'email' => 'required|email',
            'id_type' => 'nullable|string',
            'id_no' => 'nullable|string|max:20',
            'contact' => 'required|numeric',
            'qualification' =>  'nullable|string',
            'whatsapp' =>  'nullable|numeric',
            'address' =>  'nullable|string',
            'district' =>  'nullable|string',
            'state' =>  'nullable|string',
            'postoffice' =>  'nullable|string',
            'pincode' => 'nullable|string|max:20',
            // 'land_area_cultivated' =>  'nullable|string',
            // 'land_area_total' =>  'nullable|string',
            // 'referred_by' => 'nullable|string',
            // 'farming_since' =>  'nullable|string',
            // 'crop_grown' =>  'nullable|string',
            // 'info_on_all_crops' => 'nullable|string',
            // 'capital_investment' => 'nullable|string',
            // 'technology_intervention' =>  'nullable|string',
            // 'future_plans' =>  'nullable|string',
        ]);
        profileModel::where('id', $id)->update([
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'email' => $request->email,
            'id_type' => $request->id_type,
            'id_no' => $request->id_no,
            'contact' => $request->contact,
            'qualification' =>  $request->qualification,
            'whatsapp' => $request->whatsapp,
            'address' =>  $request->address,
            'district' =>  $request->district,
            'state' =>  $request->state,
            'postoffice' =>  $request->postoffice,
            'pincode' => $request->pincode,
            'land_area_cultivated' => $request->land_area_cultivated,
            'land_area_total' =>  $request->land_area_total,
            'referred_by' => $request->referred_by,
            'farming_since' =>  $request->farming_since,
            'crop_grown' =>  $request->crop_grown,
            'info_on_all_crops' => $request->info_on_all_crops,
            'capital_investment' => $request->capital_investment,
            'technology_intervention' =>  $request->technology_intervention,
            'future_plans' =>  $request->future_plans,
        ]);
        return redirect()->route('profile')->with('success', 'Profile created successfully.');
    }

    public function cropForm()
    {
        return view('farmer.crop');
    }

    public function cropStore(Request $request)
    {
        // ac_cropModel::create($validated);

        // return redirect()->route('farmer.crop')->with('success', 'Crop added successfully.');
    }

    public function fieldForm()
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();
        $profile = profileModel::where('email', $user->email)->first();
        return view('farmer.fields', compact('profile'));
    }

    public function fieldStore(Request $request)
    {
        $validated = $request->validate([
            'farmer_id' => 'required|string',
            'field_name' => 'required|string',
            'field_area' => 'required|string',
            'land_profile' => 'nullable|string',
            'road_connectivity' => 'nullable|string',
            'type_of_field' => 'nullable|string',
            'irrigation_system' => 'required|string',
            'source_of_irrigation' => 'required|string',
            'soil_type' => 'required',
            'field_latitude' => 'nullable|string',
            'field_longitude' => 'nullable|string',
            'field_boundary' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        if ($request->hasFile('field_boundary')) {
            $validated['field_boundary'] = $request->file('field_boundary')->store('fields/boundaries', 'public');
        }

        if ($request->hasFile('map_image')) {
            $validated['map_image'] = $request->file('map_image')->store('fields/maps', 'public');
        }
        fieldModel::create($validated);

        return redirect()->route('farmer.field')->with('success', 'Field added successfully.');
    }
}
