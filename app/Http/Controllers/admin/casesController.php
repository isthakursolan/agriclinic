<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\individualParameterModel;
use App\Models\packagesModel;
use App\Models\sampleTypeModel;
use Illuminate\Http\Request;

class casesController extends Controller
{
    public function typeIndex()
    {
        $types = SampleTypeModel::all();
        return view('admin.sampleType.index', compact('types'));
    }

    public function typeCreate()
    {
        return view('admin.sampleType.create');
    }

    public function typeStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'e_type' => 'required|string|max:255',
            // 'h_type' => 'required|string|max:255',
            'sample_size' => 'required|string|max:255',
            'buffer_size' => 'nullable|string|max:255',
            'batch_prefix' => 'nullable|string|max:255',
        ]);

        SampleTypeModel::create($request->all());
        return redirect()->route('admin.sampleType')->with('success', 'Sample Type created.');
    }

    public function typeEdit($id)
    {
        $sample_type = sampleTypeModel::findOrFail($id);
        return view('admin.sampleType.edit', compact('sample_type'));
    }

    public function typeUpdate(Request $request, $id)
    {
        $sample_type = sampleTypeModel::findOrFail($id);
        $request->validate([
            'e_type' => 'required|string|max:255',
            // 'h_type' => 'required|string|max:255',
            'sample_size' => 'required|string|max:255',
            'buffer_size' => 'nullable|string|max:255',
            'batch_prefix' => 'nullable|string|max:255',
        ]);

        $sample_type->update($request->all());
        return redirect()->route('admin.sampleType')->with('success', 'Sample Type updated.');
    }

    public function typeDestroy($id)
    {
        $sample_type = sampleTypeModel::findOrFail($id);
        $sample_type->delete();
        return redirect()->route('admin.sampleType')->with('success', 'Sample Type deleted.');
    }





    public function individualIndex()
    {
        $parameters = individualParameterModel::with('sampleType')->get();
        return view('admin.singlePara.index', compact('parameters'));
    }

    public function individualCreate()
    {
        $sampleTypes = sampleTypeModel::all();
        return view('admin.singlePara.create', compact('sampleTypes'));
    }

    public function individualStore(Request $request)
    {
        $request->validate([
            'parameter' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:50',
            'reporting_time' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'sample_type' => 'required|exists:sample_type,id',
            'reading_type' => 'nullable|string|max:50',
        ]);

        individualParameterModel::create($request->all());

        return redirect()->route('admin.singlePara')->with('success', 'Parameter created successfully.');
    }

    public function individualEdit($id)
    {
        $parameter = individualParameterModel::findOrFail($id);
        $sampleTypes = sampleTypeModel::all();
        return view('admin.singlePara.edit', compact('parameter', 'sampleTypes'));
    }

    public function individualUpdate(Request $request, $id)
    {
        $parameter = individualParameterModel::findOrFail($id);

        $request->validate([
            'parameter' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:50',
            'reporting_time' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'sample_type' => 'required|exists:sample_type,id',
            'reading_type' => 'nullable|string|max:50',
        ]);

        $parameter->update($request->all());

        return redirect()->route('admin.singlePara')->with('success', 'Parameter updated successfully.');
    }

    public function individualDestroy($id)
    {
        $parameter = individualParameterModel::findOrFail($id);
        $parameter->delete();

        return redirect()->route('admin.singlePara')->with('success', 'Parameter deleted successfully.');
    }





    public function packagesIndex()
    {
        $packages = packagesModel::with('sampleType')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function packagesCreate()
    {
        $sampleTypes = sampleTypeModel::all();
        $parameters = individualParameterModel::all();
        return view('admin.packages.create', compact('sampleTypes', 'parameters'));
    }

    public function packagesStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'package_name' => 'required|string|max:255',
            'sample_type' => 'required|exists:sample_type,id',
            'price' => 'required|numeric',
            'reporting_time' => 'nullable|string|max:255',
            'parameters' => 'required|json',
        ]);

        $package = packagesModel::create([
            'package_name' => $request->package_name,
            'sample_type' => $request->sample_type,
            'price' => $request->price,
            'reporting_time' => $request->reporting_time,
            'parameters' => $request->parameters, // JSON string of selected parameter IDs
        ]);

        return redirect()->route('admin.packages')->with('success', 'Package created successfully.');
    }

    public function packagesEdit($id)
    {
        $package = packagesModel::findOrFail($id);
        $sampleTypes = sampleTypeModel::all();
        $parameters = individualParameterModel::all();
        $selectedParams = json_decode($package->parameters ?? '[]', true);

        return view('admin.packages.edit', compact('package', 'sampleTypes', 'parameters', 'selectedParams'));
    }

    public function packagesUpdate(Request $request, $id)
    {
        $package = packagesModel::findOrFail($id);

        $request->validate([
            'package_name' => 'required|string|max:255',
            'sample_type' => 'required|exists:sample_type,id',
            'price' => 'required|numeric',
            'reporting_time' => 'nullable|string|max:255',
            'parameters' => 'required|json',
        ]);

        $package->update([
            'package_name' => $request->package_name,
            'sample_type' => $request->sample_type,
            'price' => $request->price,
            'reporting_time' => $request->reporting_time,
            'parameters' => $request->parameters, // JSON string of selected parameter IDs
        ]);

        return redirect()->route('admin.packages')->with('success', 'Package updated successfully.');
    }

    public function packagesDestroy($id)
    {
        $package = packagesModel::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages')->with('success', 'Package deleted successfully.');
    }
}
