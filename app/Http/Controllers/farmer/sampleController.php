<?php

namespace App\Http\Controllers\farmer;

use App\Http\Controllers\Controller;
use App\Models\activecropModel;
use App\Models\concernModel;
use App\Models\cropModel;
use App\Models\fieldModel;
use App\Models\individualParameterModel;
use App\Models\packagesModel;
use App\Models\paymentsModel;
use App\Models\profileModel;
use App\Models\sampleModel;
use App\Models\sampleTypeModel;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sampleController extends Controller
{
    public function index()
    {
        $samples = SampleModel::where('farmer_id', session('id'))->with('payments')->get();
        $field = fieldModel::get();
        $crop = activecropModel::get();
        $type = sampleTypeModel::get();
        return view('farmer.sample.index', compact('samples', 'field', 'crop', 'type'));
    }
    public function create()
    {
        $profile = profileModel::where('id', session('id'))->first();
        $sample_type = sampleTypeModel::get();
        $field = fieldModel::where('farmer_id', session('id'))->get();
        $crop = activecropModel::where('farmer_id', session('id'))->get();
        return view('farmer.sample.create', compact('profile', 'sample_type', 'field', 'crop'));
    }

    public function getSampleTypeData($id)
    {
        $concerns = concernModel::where('sample_type', $id)->get();
        // Get individual parameters for this sample type
        $parameters = individualParameterModel::where('sample_type', $id)->get();

        // Get packages and their parameters
        $packages = packagesModel::where('sample_type', $id)
            ->get()
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'package_name' => $pkg->package_name,
                    'parameters' => json_decode($pkg->parameters) ?? [],
                    'price' => $pkg->price ?? 0,
                    'time' => $pkg->reporting_time,
                ];
            });
        return response()->json([
            'concerns' => $concerns,
            'parameters' => $parameters,
            'packages' => $packages,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'sample_type' => 'required|exists:sample_type,id',
            'packages' => 'nullable|exists:packages,id',
            'parameters' => 'required|string', // JSON string from JS
            'amount' => 'required|numeric'
        ]);
        // Decode parameters JSON
        $parameters = json_decode($request->parameters, true) ?? [];
        // Step 1: Create sample
        $sample = sampleModel::create([
            'farmer_id' => $request->farmer_id,
            'field_id' => $request->field_id,
            'crop_id' => $request->crop_id,
            'sample_type' => $request->sample_type,
            'collection_method' => $request->collection_method,
            'package' => $request->packages,
            'parameters' => $parameters, // store as JSON in DB
            'quantity' => $request->quantity,
            'amount' => $request->amount,
            'concern' => $request->concern,
            'sample_status' => 'pending',
        ]);
        return response()->json(['success' => true, 'sample' => $sample]);
    }
    public function edit($id)
    {
        $sample = sampleModel::with(['sampleType', 'package'])->findOrFail($id);

        // Get packages and parameters for the sample's type
        $packages = packagesModel::with('parameters')
            ->where('sample_type', $sample->sample_type)
            ->get();
        $parameters = individualParameterModel::where('sample_type', $sample->sample_type)->get();
        $profile = profileModel::where('id', session('id'))->first();
        $concerns = concernModel::get();
        $field = fieldModel::where('farmer_id', session('id'))->get();
        $crop = activecropModel::where('farmer_id', session('id'))->get();
        return view('farmer.sample.edit', [
            'sample' => $sample,
            'sample_type' => sampleTypeModel::all(),
            'packages' => $packages,
            'parameter' => $parameters,
            'profile' => $profile,
            'concerns' => $concerns,
            'field' => $field,
            'crop' => $crop,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sample = sampleModel::findOrFail($id);
        if ($sample->sample_status != 'pending' && $sample->sample_status != 'paid') {
            return redirect()->route('user.sample')->with('error', 'This sample has been processed and cannot be edited.');
        }

        $validated = $request->validate([
            'sample_type' => 'required|exists:sample_type,id',
            'quantity' => 'required|string',
            'package' => 'nullable|exists:packages,id',
            'parameters' => 'nullable|array',
            'parameters.*' => 'exists:individual_parameter,id',
            'concern' => 'nullable|exists:concern,id',
            'collection_method' => 'required|in:self,agent',
            'amount' => 'required|numeric',
        ]);

        $all_parameter_ids = $validated['parameters'] ?? [];

        if (!empty($validated['package'])) {
            $package = \App\Models\packagesModel::find($validated['package']);
            if ($package && $package->parameters) {
                $package_params = json_decode($package->parameters, true);
                if (is_array($package_params)) {
                    $all_parameter_ids = array_merge($all_parameter_ids, $package_params);
                }
            }
        }

        $sample->update([
            'sample_type' => $validated['sample_type'],
            'quantity' => $validated['quantity'],
            'package' => $validated['package'] ?? null,
            'parameters' => array_unique($all_parameter_ids), // Merged and unique
            'concern' => $validated['concern'],
            'collection_method' => $validated['collection_method'],
            'amount' => $validated['amount'],
        ]);

        return redirect()->route('user.sample.edit', $sample->id)->with('success', 'Sample updated successfully.');
    }

    public function details($id)
    {
        $sample = sampleModel::with(['farmer', 'crop', 'field','investigations.parameters'])
            ->where('farmer_id', session('id'))
            ->findOrFail($id);

        $payment = \App\Models\paymentsModel::whereJsonContains('sample_id', $id)->first();

        return view('farmer.sample.details', compact('sample', 'payment'));
    }

    // public function getSampleParameters($sampleId)
    // {
    //     $sample = sampleModel::with(['field', 'crop', 'package', 'sampleType', 'investigations', 'payments'])->where('id', $id)
    //         ->where('farmer_id', session('id'))
    //         ->firstOrFail();
    //     // dd($sample);
    //     return view('farmer.sample.details', compact('sample'));
    // }
}
