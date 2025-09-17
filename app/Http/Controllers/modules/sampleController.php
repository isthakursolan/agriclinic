<?php

namespace App\Http\Controllers\modules;

use App\Http\Controllers\Controller;
use App\Models\activecropModel;
use App\Models\concernModel;
use App\Models\cropModel;
use App\Models\fieldModel;
use App\Models\individualParameterModel;
use App\Models\investigationsModel;
use App\Models\packagesModel;
use App\Models\paymentsModel;
use App\Models\profileModel;
use App\Models\sampleModel;
use App\Models\sampleTypeModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Illuminate\Http\JsonResponse;

class sampleController extends Controller
{
    public function index()
    {
        $samples = SampleModel::get();
        $field = fieldModel::get();
        $crop = activecropModel::get();
        $type = sampleTypeModel::get();
        return view('modules.sample.index', compact('samples', 'field', 'crop', 'type'));
    }
    public function create()
    {
        $profile = User::role('farmer')->with('profile', 'activeCrops', 'fields')->get();
        $sample_type = sampleTypeModel::get();
        return view('modules.sample.create', compact('profile', 'sample_type'));
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
        // Step 4: Redirect **outside the transaction**
        // return redirect()->route('user.payments.show')
        //     ->with('success', 'Sample created successfully. Proceed to payment.');
        // return redirect()->route('user.sample.create')
        //     ->with('success', 'Sample created successfully. Proceed to payment.');
    }
    public function edit(sampleModel $sample)
    {
        return response()->json([
            'success' => true,
            'sample' => $sample
        ]);
    }
    public function show(Request $request)
    {
        // $id = session('id');
        $id = $request->query('farmer_id');
        $sample = sampleModel::where('farmer_id', $id)
            ->where('sample_status', 'pending')
            ->get();

        $totalAmount = $sample->sum('amount');

        return view('modules.sample.paymentShow', compact('sample', 'totalAmount', 'id'));
    }

    public function confirm(Request $request, $sampleId)
    {
        // dd($request->all());

        $request->validate([
            'samples' => 'required|array|min:1',
            'amount' => 'required|numeric|min:1',
            'mode' => 'required|string',
            'transaction_id' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $samples = sampleModel::whereIn('id', $request->samples)->get();

                $totalAmount = $samples->sum('amount');
                $sampleIds = $samples->pluck('id')->toArray();
                // Step 1: Create a single payment record
                $payment = paymentsModel::create([
                    'date' => now(),
                    'amount' => $totalAmount,
                    'sample_id' => json_encode($sampleIds), // save all ids as JSON
                    'no_of_samples' => count($sampleIds),
                    'mode' => $request->mode,
                    'transaction_id' => $request->transaction_id,
                    'confirm_payment' => '1',
                    'status' => 'paid'
                ]);

                // Step 2: Update samples and link with payment
                foreach ($samples as $sample) {
                    $sample->update([
                        'sample_status' => 'paid',
                    ]);

                    // Step 3: Save investigation records for each parameter
                    foreach ($sample->parameters as $paramId) {
                        investigationsModel::create([
                            'sample_id' => $sample->id,
                            'parameter' => $paramId
                        ]);
                    }
                }
            });

            return redirect()->route('sample')
                ->with('success', 'Payment successful! Samples updated and investigations created.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        // return redirect()->route('user.sample')->with('success', 'Payment confirmed and investigations created!');
    }

    public function sampleEdit($id)
    {
        $sample = sampleModel::with(['sampleType'])->find($id);
        // Get sample type data to pre-fill packages/parameters dropdowns
        $sampleTypeData = $this->getSampleTypeData($sample->sample_type)->getData(true);
        $parameters = $sampleTypeData['parameters'] ?? [];
        $packages = $sampleTypeData['packages'] ?? [];
        $concerns = $sampleTypeData['concerns'] ?? [];
        // Decode JSON values for parameters and packages to match expected structure
        $selectedParams = $sample->parameters ?: [];
        $selectedPackages = $sample->packages ?: [];

        // Pass sample type options
        $sampleTypes = sampleTypeModel::all();

        // Pass farmer and other data
        $farmers = User::role('farmer')
            ->with(['profile', 'fields', 'activeCrops'])
            ->get();
        // Pre-load packages/parameters data for selected sample type
        // This will populate the dropdowns in the edit form automatically
        return view('modules.sample.edit', compact(
            'sample',
            'parameters',
            'packages',
            'concerns',
            'sampleTypes',
            'farmers',
            'selectedParams',
            'selectedPackages'
        ));
    }
    public function sampleUpdate(Request $request, $id)
    {
        $request->validate([
            'sample_type' => 'required|exists:sample_type,id',
            'parameters' => 'required|string',
            'packages' => 'nullable|array',
            'concern' => 'nullable|string',
        ]);
        $parameters = json_decode($request->parameters, true) ?? [];
        $sample = sampleModel::find($id);

        $sample->update([
            'sample_type' => $request->sample_type,
            'package' => $request->packages,
            'parameters' => $parameters, // st
            'concern' => $request->concern,
        ]);
        return redirect()->route('samples.index')
            ->with('success', 'Sample updated successfully.');
    }
}
