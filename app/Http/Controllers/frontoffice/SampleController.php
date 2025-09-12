<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\individualParameterModel;
use App\Models\packagesModel;
use App\Models\profileModel;
use App\Models\sampleModel;
use App\Models\sampleMovementModel;
use App\Models\sampleTypeModel;
use App\Models\User;
use App\Models\paymentsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SampleController extends Controller
{
    public function index()
    {
        $samples = sampleModel::with(['farmer', 'sampleType'])->orderBy('sample_id', 'asc')->get();
        // echo "<pre>"; print_r($samples->toArray()); echo "</pre>"; exit;
        return view('frontoffice.samples.index', compact('samples'));
    }

    public function create()
    {
        $farmers = User::role('farmer')->with(['profile', 'fields', 'activeCrops'])->get();
        $sampleTypes = sampleTypeModel::all();
        // Packages and Parameters will be loaded via AJAX
        return view('frontoffice.samples.create', compact('farmers', 'sampleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'farmer_id'      => 'required|exists:users,id',
            'sample_type_id' => 'required|exists:sample_type,id',
            'amount'         => 'required|numeric',
            'parameters'     => 'required|string', // JSON string
            'field_id'       => 'nullable|exists:field,id',
            'crop_id'        => 'nullable|exists:active_crop,id',
            'packages' => 'nullable|array',
        ]);
        // Generate a unique sample ID
        $sampleType = sampleTypeModel::find($request->sample_type_id);
        $prefix = $sampleType->batch_prefix ?? 'SMP';
        $uniqueId = $prefix . '-' . date('Ymd') . '-' . strtoupper(uniqid());

        $parameters = json_decode($request->parameters, true) ?? [];

        $sample = sampleModel::create([
            'sample_id'      => $uniqueId,
            'farmer_id'      => $request->farmer_id,
            'sample_type_id' => $request->sample_type_id,
            'field_id'       => $request->field_id,
            'crop_id'        => $request->crop_id,
            'parameters'     => json_encode($parameters),
            'packages'       => json_encode($request->packages ?? []),
            'amount'         => $request->amount,
            'remarks'        => $request->remarks,
            'sample_status'  => 'pending', // Default status
            'created_by'     => Auth::id(),
        ]);
        // Create initial movement record
        sampleMovementModel::create([
            'sample_id' => $sample->id,
            'user_id' => Auth::id(),
            'action' => 'Sample Registered',
            'target' => 'Front Office',
            'timestamp' => now(),
        ]);

        return response()->json(['success' => true, 'sample' => $sample]);
    }

    public function track(Request $request)

    {
        $sample = null;
        $trackingHistory = null;

        if ($request->has('sample_id')) {
            $sampleId = $request->input('sample_id');
            $sample = sampleModel::where('sample_id', $sampleId)->first();

            if ($sample) {
                $trackingHistory = sampleMovementModel::where('sample_id', $sample->id)
                    ->with('user.profile') // Assuming user is linked to profileModel
                    ->orderBy('timestamp', 'asc')
                    ->get();
            } else {
                return back()->with('error', 'Sample ID not found.')->withInput();
            }
        }

        return view('frontoffice.samples.track', compact('sample', 'trackingHistory'));
    }

    // AJAX endpoint to get parameter/package prices
    public function getPrices(Request $request)
    {
        $total = 0;
        if ($request->has('parameters')) {
            $total += individualParameterModel::whereIn('id', $request->parameters)->sum('amount');
        }
        if ($request->has('packages')) {
            $total += packagesModel::whereIn('id', $request->packages)->sum('amount');
        }


        return response()->json(['total' => $total]);
    }

    public function paymentShow($farmer_id)
    {
        $farmer = User::with('profile')->findOrFail($farmer_id);
        $samples = sampleModel::where('farmer_id', $farmer_id)
            ->where('sample_status', 'pending')
            ->get();

        $totalAmount = $samples->sum('amount');

        return view('frontoffice.samples.paymentShow', compact('samples', 'totalAmount', 'farmer'));
    }

    public function getSampleTypeData($id)
    {
        // Get individual parameters for this sample type
        $parameters = individualParameterModel::where('sample_type', $id)->get();

        // Get packages for this sample type
        $packages = packagesModel::where('sample_type', $id)
            ->get()
            ->map(function ($pkg) {
                return [
                    'id' => $pkg->id,
                    'name' => $pkg->package_name,
                    'parameters' => json_decode($pkg->parameters) ?? [],
                    'amount' => $pkg->price ?? 0,
                ];
            });

        return response()->json([
            'parameters' => $parameters,
            'packages' => $packages,
        ]);
    }
}
