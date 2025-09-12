<?php

namespace App\Http\Controllers\farmer;

use App\Models\ac_cropModel;
use Illuminate\Support\Facades\Storage;
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
        return view('farmer.profile.index', compact('profile'));
    }
    public function profileEdit()
    {
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
        return view('farmer.profile.profile', compact('profile'));
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
        $crops = activecropModel::where('farmer_id', session('id'))->get();
        $plots = fieldModel::where('farmer_id', session('id'))->get();
        return view('farmer.crop.crop', compact('crops', 'plots'));
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

    public function cropEdit($id)
    {

        $cropReg = activeCropModel::with(['crop.category', 'crop.cropType', 'farmer', 'plot'])->findOrFail($id);
        $crops = cropModel::with(['varieties', 'rootstocks'])->get();
        $fields = fieldModel::where('farmer_id', $cropReg->farmer_id)->get();
        return view('farmer.crop.edit', compact('crops', 'fields', 'cropReg'));
    }

    public function cropUpdate(Request $request, $id)
    {
        $cropReg = activeCropModel::findOrFail($id);

        $validated = $request->validate([
            'sowing_date' => 'nullable|date',
            'expected_harvest_date' => 'nullable|date',
            'fertilizer_plan' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('crops', 'public');
        }

        $cropReg->update($validated);


        return redirect()->route('user.crop')->with('success', 'Crop updated successfully.');
    }

    public function cropDestroy($id)
    {
        $cropReg = activecropModel::findOrFail($id);

        if ($cropReg->photo && Storage::disk('public')->exists($cropReg->photo)) {
            Storage::disk('public')->delete($cropReg->photo);
        }

        $cropReg->delete();

        return redirect()->route('user.crop')->with('success', 'Crop deleted successfully.');
    }

    public function field()
    {
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
        // $fields = fieldModel::where('farmer_id', $id)->with('crop')->get();
        $fields = fieldModel::where('farmer_id', $id)
            ->with('lastCrop')
            ->get();

        // echo $fields;
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
    public function fieldEdit($field_id)
    {
        $id = session('id');
        $profile = profileModel::where('id', $id)->first();
        $field = fieldModel::where('id', $field_id)->first();
        return view('farmer.field.edit', compact('profile', 'field'));
    }
    public function fieldUpdate(Request $request, $field_id)
    {
        $field = fieldModel::findOrFail($field_id);

        $validated = $request->validate([
            'farmer_id' => 'required|integer',
            'field_name' => 'required|string|max:255',
            'field_area' => 'required|numeric',
            'land_profile' => 'nullable|string',
            'road_connectivity' => 'nullable|boolean',
            'type_of_field' => 'nullable|string|max:255',
            'irrigation_system' => 'nullable|boolean',
            'source_of_irrigation' => 'nullable|string|max:255',
            'soil_type' => 'required|string|max:100',
            'field_latitude' => 'nullable|string',
            'field_longitude' => 'nullable|string',
            'field_boundary' => 'nullable|string',
            'description' => 'nullable|string',
            'map_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle map image upload (replace old if new one uploaded)
        if ($request->hasFile('map_image')) {
            // Delete old map image if exists
            if ($field->map_image && Storage::disk('public')->exists($field->map_image)) {
                Storage::disk('public')->delete($field->map_image);
            }
            $validated['map_image'] = $request->file('map_image')->store('fields/maps', 'public');
        }

        $field->update($validated);
        return redirect()->route('user.field')->with('success', 'Field added successfully.');
    }
    public function fieldDestroy($id)
    {
        $field = fieldModel::findOrFail($id);

        if ($field->map_image && Storage::disk('public')->exists($field->map_image)) {
            Storage::disk('public')->delete($field->map_image);
        }

        $field->delete();

        return redirect()->route('user.field')->with('success', 'Field deleted successfully.');
    }
}
