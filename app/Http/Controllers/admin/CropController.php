<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cropcatModel;
use App\Models\cropModel;
use App\Models\croptypeModel;
use App\Models\rootstockModel;
use App\Models\varietyModel;

class CropController extends Controller
{
    // ----- Crop Categories -----
    public function indexCategory()
    {
        $categories = cropcatModel::all();
        return view('admin.crops.crop-cat.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.crops.crop-cat.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['e_cat' => 'required|unique:crop_cat,e_cat']);
        cropcatModel::create($request->only('e_cat'));
        return redirect()->route('admin.crop.cat')->with('success', 'Category created.');
    }

    public function editCategory($id)
    {
        $cropCat = cropcatModel::findOrFail($id);
        return view('admin.crops.crop-cat.edit', compact('cropCat'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'e_cat' => 'required|string|max:255',
        ]);
        $cropCat = cropcatModel::findOrFail($id);
        $cropCat->update([
            'e_cat' => $request->e_cat,
        ]);
        return redirect()->route('admin.crop.cat')->with('success', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        $cropCat = cropcatModel::findOrFail($id);
        $cropCat->delete();
        return redirect()->route('admin.crop.cat')->with('success', 'Category deleted.');
    }

    // ----- Crop Types -----
    public function indexType()
    {
        $types = croptypeModel::all();
        return view('admin.crops.crop-type.index', compact('types'));
    }

    public function createType()
    {
        return view('admin.crops.crop-type.create');
    }

    public function storeType(Request $request)
    {
        $request->validate([
            'e_type' => 'required|unique:crop_type,e_type',
        ]);
        croptypeModel::create($request->only('e_type'));
        return redirect()->route('admin.crop.type')->with('success', 'Type created.');
    }

    public function editType($id)
    {
        $cropType = croptypeModel::findOrFail($id);
        return view('admin.crops.crop-type.edit', compact('cropType'));
    }

    public function updateType(Request $request, $id)
    {
        $request->validate([
            'e_type' => 'required|unique:crop_type,e_type|string',
        ]);
        $type = croptypeModel::findOrFail($id);
        $type->update([
            'e_type' => $request->e_type,
        ]);
        return redirect()->route('admin.crop.type')->with('success', 'Type updated.');
    }

    public function destroyType($id)
    {
        $cropType = croptypeModel::findOrFail($id);
        $cropType->delete();
        return redirect()->route('admin.crop.type')->with('success', 'Type deleted.');
    }

    // ----- Crops -----
    public function index()
    {
        $crops = cropModel::with(['cropType', 'category'])->get();
        return view('admin.crops.crop.index', compact('crops'));
    }

    public function create()
    {
        $categories = cropcatModel::all();
        $types = croptypeModel::all();
        return view('admin.crops.crop.create', compact('categories', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'crop' => 'required|unique:crop,crop',
            'cat' => 'required|exists:crop_cat,id',
            'type' => 'required|exists:crop_type,id',
            'variety' => 'required',
            'rootstock' => 'required',
            'aging' => 'nullable',
        ]);
        cropModel::create($request->only('crop', 'cat', 'type', 'variety', 'rootstock', 'aging'));
        return redirect()->route('admin.crop')->with('success', 'Crop created.');
    }

    public function edit($id)
    {
        $crop = cropModel::findorfail($id);
        $categories = cropcatModel::all();
        $types = croptypeModel::all();
        $varieties = varietyModel::all();
        $rootstocks = rootstockModel::all();
        return view('admin.crops.crop.edit', compact('crop', 'categories', 'types', 'varieties', 'rootstocks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'crop' => 'required|unique:crop,crop,',
            'cat' => 'required|exists:crop_cat,id',
            'type' => 'required|exists:crop_type,id',
            'variety' => 'required',
            'rootstock' => 'required',
            'aging' => 'nullable',
        ]);
        $crop = cropModel::findOrFail($id);
        $crop->update($request->only('crop', 'cat', 'type', 'variety', 'rootstock', 'aging'));
        return redirect()->route('admin.crop')->with('success', 'Crop updated.');
    }

    public function destroy($id)
    {
        $crop = cropModel::findOrFail($id);
        $crop->delete();
        return redirect()->route('admin.crop')->with('success', 'Crop deleted.');
    }

    // ----- Varieties -----
    public function indexVariety()
    {
        $crops = cropModel::with('varieties')->where('variety', 1)->get();
        return view('admin.crops.variety.index', compact('crops'));
    }

    public function createVariety()
    {
        $crops = cropModel::where('variety', 1)->get();
        return view('admin.crops.variety.create', compact('crops'));
    }

    public function storeVariety(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'crop' => 'required|exists:crop,id',
            'varieties.*' => 'required|string|max:255',
        ]);

        foreach ($request->varieties as $varietyName) {
            varietyModel::create([
                'crop' => $request->crop,
                'variety' => $varietyName,
            ]);
        }
        return redirect()->route('admin.variety')->with('success', 'Varieties added successfully!');
    }

    public function editVariety($crop_id)
    {
        $crop = cropModel::with('varieties')->findOrFail($crop_id);
        return view('admin.crops.variety.edit', compact('crop'));
    }

    public function updateVariety(Request $request, $crop_id)
    {
        $request->validate([
            'varieties.*.id' => 'nullable|exists:variety,id',
            'varieties.*.name' => 'required|string|max:255',
        ]);

        $crop = cropModel::findOrFail($crop_id);

        $existingVarietyIds = $crop->varieties->pluck('id')->toArray();
        $submittedVarietyIds = [];

        foreach ($request->varieties as $var) {
            if (isset($var['id'])) {
                // Update existing variety
                $variety = varietyModel::find($var['id']);
                $variety->update(['variety' => $var['name']]);
                $submittedVarietyIds[] = $var['id'];
            } else {
                // Create new variety
                $newVariety = varietyModel::create([
                    'crop_id' => $crop->id,
                    'variety' => $var['name'],
                ]);
                $submittedVarietyIds[] = $newVariety->id;
            }
        }

        // Optionally delete removed varieties
        $toDelete = array_diff($existingVarietyIds, $submittedVarietyIds);
        if (!empty($toDelete)) {
            varietyModel::whereIn('id', $toDelete)->delete();
        }
        return redirect()->route('admin.variety')->with('success', 'Varieties updated successfully!');
    }

    public function destroyVariety($crop_id)
    {
        $crop = cropModel::findOrFail($crop_id);
        $crop->varieties()->delete();

        return redirect()->route('admin.variety.index')->with('success', 'All varieties deleted successfully!');
    }

    public function destroySingle($id)
    {
        $variety = varietyModel::findOrFail($id);
        $variety->delete();

        return redirect()->back()->with('success', 'Variety deleted successfully!');
    }

    // ----- Rootstocks -----
    public function indexRootstock()
    {
        $crops = cropModel::where('rootstock', 1)->get();
        return view('admin.crops.rootstock.index', compact('crops'));
    }

    public function createRootstock()
    {
        $crops = cropModel::where('rootstock', 1)->get();
        return view('admin.crops.rootstock.create', compact('crops'));
    }

    public function storeRootstock(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'crop' => 'required|exists:crop,id',
            'rootstocks.*' => 'required|string|max:255',
        ]);

        foreach ($request->rootstocks as $name) {
            rootstockModel::create([
                'crop' => $request->crop,
                'rootstock' => $name,
            ]);
        }
        return redirect()->route('admin.rootstock')->with('success', 'Rootstock added successfully!');
    }

    public function editRootstock($crop_id)
    {
        $crop = cropModel::with('rootstocks')->findOrFail($crop_id);
        return view('admin.crops.rootstock.edit', compact('crop'));
    }

    public function updateRootstock(Request $request, $crop_id)
    {
        $request->validate([
            'rootstocks.*.id' => 'nullable|exists:rootstock,id',
            'rootstocks.*.name' => 'required|string|max:255',
        ]);

        $crop = cropModel::findOrFail($crop_id);

        $existingIds = $crop->rootstocks->pluck('id')->toArray();
        $submittedIds = [];

        foreach ($request->rootstocks as $r) {
            if (isset($r['id'])) {
                $root = rootstockModel::find($r['id']);
                $root->update(['rootstock' => $r['name']]);
                $submittedIds[] = $r['id'];
            } else {
                $newRoot = rootstockModel::create([
                    'crop_id' => $crop->id,
                    'rootstock' => $r['name'],
                ]);
                $submittedIds[] = $newRoot->id;
            }
        }

        // Delete removed rootstocks
        $toDelete = array_diff($existingIds, $submittedIds);
        if ($toDelete) {
            rootstockModel::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.rootstock')->with('success', 'Rootstocks updated successfully!');
    }

    public function destroyRootstock($crop_id)
    {
        $crop = cropModel::findOrFail($crop_id);
        $crop->rootstocks()->delete();

        return redirect()->route('admin.rootstock')->with('success', 'All rootstocks deleted successfully!');
    }
    public function destroySingleRoot($id)
    {
        $root = rootstockModel::findOrFail($id);
        $root->delete();

        return redirect()->back()->with('success', 'Rootstock deleted successfully!');
    }




     public function indexCrops()
    {
        $crops = cropModel::with(['varieties', 'rootstocks'])->where('variety',1)->where('rootstock',1)->get();
        return view('admin.crops.relations.index', compact('crops'));
    }

    public function createCrops()
    {
        $crops = cropModel::all();
        return view('admin.crops.relations.create', compact('crops'));
    }

    public function storeCrops(Request $request)
    {
        $request->validate([
            'crop_id' => 'required|exists:crop,id',
        ]);

        $crop = cropModel::findOrFail($request->crop_id);

        // ✅ Save Varieties
        if ($request->varieties) {
            foreach ($request->varieties as $variety) {
                if (!empty($variety['name'])) {
                    varietyModel::create([
                        'crop' => $crop->id,
                        'variety' => $variety['name'],
                    ]);
                }
            }
        }

        // ✅ Save Rootstocks
        if ($request->rootstocks) {
            foreach ($request->rootstocks as $rootstock) {
                if (!empty($rootstock['name'])) {
                    rootstockModel::create([
                        'crop' => $crop->id,
                        'rootstock' => $rootstock['name'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.crops')->with('success', 'Relations added successfully!');
    }

    public function editCrops($id)
    {
        $crop = cropModel::with(['varieties', 'rootstocks'])->findOrFail($id);
        return view('admin.crops.relations.edit', compact('crop'));
    }

    public function updateCrops(Request $request, $id)
    {
        $crop = cropModel::findOrFail($id);

        // Delete old
        $crop->varieties()->delete();
        $crop->rootstocks()->delete();

        // ✅ Update Varieties
        if ($request->varieties) {
            foreach ($request->varieties as $variety) {
                if (!empty($variety['name'])) {
                    varietyModel::create([
                        'crop' => $crop->id,
                        'variety' => $variety['name'],
                    ]);
                }
            }
        }

        // ✅ Update Rootstocks
        if ($request->rootstocks) {
            foreach ($request->rootstocks as $rootstock) {
                if (!empty($rootstock['name'])) {
                    rootstockModel::create([
                        'crop' => $crop->id,
                        'rootstock' => $rootstock['name'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.crops')->with('success', 'Relations updated successfully!');
    }

    public function destroyCrops($id)
    {
        $crop = cropModel::findOrFail($id);
        $crop->varieties()->delete();
        $crop->rootstocks()->delete();

        return redirect()->route('admin.crops')->with('success', 'Relations deleted successfully!');
    }





}
