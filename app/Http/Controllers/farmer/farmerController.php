<?php

namespace App\Http\Controllers\farmer;

use App\Models\ac_cropModel;
use App\Http\Controllers\Controller;
use App\Models\activecropModel;
use App\Models\cropcatModel;
use App\Models\cropModel;
use App\Models\croptypeModel;
use App\Models\fieldModel;
use App\Models\profileModel;
use App\Models\rootstockModel as ModelsRootstockModel;
use App\Models\User;
use App\Models\varietyModel;
use App\Modes\rootstockModel;
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
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
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
        return redirect()->route('user.profile')->with('success', 'Profile created successfully.');
    }

    public function crop()
    {
        $crops= activecropModel::where('farmer_id',session('id'))->get();
        $plots= fieldModel::where('farmer_id',session('id'))->get();
        return view('farmer.crop.crop',compact('crops','plots'));
    }
    public function cropForm()
    {
        $crops = cropModel::get();
        $cropType = croptypeModel::get();
        $farmer = profileModel::where('id', session('id'))->first();
        $fields = fieldModel::where('farmer_id', session('id'))->get();
        return view('farmer.crop.add', compact('crops', 'cropType', 'farmer', 'fields'));
    }
    public function getCropType($cropType)
    {
        $type = croptypeModel::where('id', $cropType)->first();
        return response()->json($type->e_type);
    }
    public function getCropCat($cropCat)
    {
        $cat = cropcatModel::where('id', $cropCat)->first();
        return response()->json($cat->e_cat);
    }
    // AJAX: Get varieties by crop id
    public function getVarieties($cropId)
    {
        $variety = VarietyModel::where('crop', $cropId)->get();
        return response()->json($variety);
    }

    // AJAX: Get rootstocks by crop id
    public function getRootstocks($cropId)
    {
        $rootstock = ModelsRootstockModel::where('crop', $cropId)->get();
        return response()->json($rootstock);
    }
    public function cropStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'crop_cat' => 'required|string',
            'variety' => 'nullable|string',
            'rootstock' => 'nullable|string',
            'sowing_date' => 'nullable|date',
            'expected_harvest_date' => 'nullable|date',
            'fertilizer_plan' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'description' => 'nullable|string'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('crop_photos', 'public');
        }

        activecropModel::create([
            'name' => $request->name,
            'crop_cat' => $request->crop_cat,
            'farmer_id' => Auth::id(),
            'plot_id' => $request->plot_id,
            'variety' => $request->variety,
            'rootstock' => $request->rootstock,
            'sowing_date' => $request->sowing_date,
            'expected_harvest_date' => $request->expected_harvest_date,
            'fertilizer_plan' => $request->fertilizer_plan,
            'photo' => $photoPath,
            'description' => $request->description,
        ]);

        return redirect()->route('user.crop')->with('success', 'Crop added successfully!');
    }

    public function field()
    {
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
        $fields = fieldModel::where('farmer_id', $id)->get();
        return view('farmer.field.fields', compact('profile', 'fields'));
    }
    public function fieldForm()
    {
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
        return view('farmer.field.add', compact('profile'));
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

        return redirect()->route('user.field')->with('success', 'Field added successfully.');
    }
}
