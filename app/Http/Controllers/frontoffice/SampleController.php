<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\batchModel;
use App\Models\individualParameterModel;
use App\Models\labRefModel;
use App\Models\packagesModel;
use App\Models\profileModel;
use App\Models\sampleModel;
use App\Models\sampleBufferModel;
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
        // Corrected code here (highlighted part)
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

    public function acceptIndex()
    {
        // Fetch only collected samples that aren't yet accepted
        // $samples = sampleBufferModel::with('sample')->get()->pluck('sample');
        $samples = sampleModel::with(['farmer', 'fieldAgent', 'payment'])
            ->where(function ($query) {
                // Include samples collected via 'post' or 'self'
                $query->whereIn('collection_method', ['post', 'self']);
                // Include samples collected via 'field_agent' that are marked as 'collected'
                $query->orWhere(function ($subquery) {
                    $subquery->where('collection_method', 'field_agent')
                        ->where('sample_status', 'collected');
                });
            })
            ->where('sample_status', '!=', 'accepted')
            ->get();
        // echo $samples;
        $agents = User::role('field_agent')->with('profile')->get();
        return view('frontoffice.samples.accept', compact('samples', 'agents'));
    }

    public function acceptSample(Request $request)
    {
        $request->validate([
            'sample_ids' => 'required|array',
            'sample_ids.*' => 'exists:sample,id'
        ]);

        foreach ($request->input('sample_ids') as $sampleId) {
            $sample = sampleModel::findOrFail($sampleId);

            $hasValidPayment = $sample->payments()->where('status', 'paid')->exists();

            // if (!$hasValidPayment) {
            //     // No valid payment found for this sample
            //     $sample->update([
            //         'sample_status' => 'rejected',
            //         'rejection_reason' => 'No payment received.',
            //     ]);
            //     continue;
            // }

            // Payment valid — accept sample
            $sample->update([
                'sample_status' => 'accepted',
                'verify_payment' => 1, // ✅ Mark payment verified
                'accepted_at' => now(),
            ]);

            // Accept the sample
            sampleBufferModel::create([
                'sample_id' => $sample->id,
                'sample_type' => $sample->sample_type,
                'accept_by' => Auth::id(),
            ]);
        }

        return redirect()->route('frontoffice.samples.accept')
            ->with('success', 'Samples processed successfully.');
    }

    public function rejectSample(Request $request, $sampleId)
    {
        $sample = sampleModel::findOrFail($sampleId);

        $sample->update([
            'sample_status' => 'rejected',
            'rejection_reason' => $request->input('reason'),
        ]);

        return redirect()->back()->with('success', "Sample #{$sampleId} rejected.");
    }

    public function allBatch()
    {
        $batches = batchModel::with('sampleType')->orderBy('created_at', 'desc')->get();
        return view('frontoffice.batches.index', compact('batches'));
    }

    public function batch()
    {
        // $samples = sampleModel::where('sample_status','accepted')->with('sampleType')->get();
        // return view('frontoffice.batches.create', compact('samples'));
        $samples = sampleModel::where('sample_status', 'accepted')
            ->whereDoesntHave('buffer') // Only show samples not in any batch
            ->with('sampleType') // Ensure relationship is loaded
            ->get();
        return view('frontoffice.batches.create', compact('samples'));
    }

    protected function processBatches()
    {
        $sampleTypeGroups = [];

        // Get all accepted samples not in a batch
        $samples = sampleModel::where('sample_status', 'accepted')
            ->whereNull('batch_id')
            ->with('sampleType')
            ->get(); // Make sure you have a `sampleType` relationship

        foreach ($samples as $sample) {
            if ($sample->sampleType && $sample->sampleType->buffer_size > 0) {
                $type = $sample->sampleType->id;
                $sampleTypeGroups[$type][] = $sample;
            }
        }

        foreach ($sampleTypeGroups as $typeId => $group) {
            $sampleType = sampleTypeModel::find($typeId);
            $bufferSize = $sampleType->buffer_size;

            // Process in batches of buffer_size or less
            $chunks = array_chunk($group, $bufferSize);

            foreach ($chunks as $chunk) {
                $this->createBatchFromSamples($chunk, $sampleType);
            }
        }
    }
    protected function createBatchFromSamples($chunk, $sampleType)
    {
        // Create batch and assign lab references
        $batchNumber = $this->generateNextBatchNumber($sampleType);

        $batch = batchModel::create([
            'batch_no' => $batchNumber,
            'sample_type' => $sampleType->id,
            'date' => now(),
            'sample_no' => count($chunk),
            'batch_status' => 'created',
        ]);

        foreach ($chunk as $index => $sample) {
            labRefModel::create([
                'sample_id' => $sample->id,
                'batch_no' => $batch->batch_no,
                'lab_ref_no' => $index + 1,
            ]);
            $sample->update(['batch_id' => $batch->id]);
            // 🚫 Remove from buffer
            sampleBufferModel::where('sample_id', $sample->id)->delete();
        }
    }
    protected function generateNextBatchNumber($sampleType)
    {
        $prefix = $sampleType->batch_prefix;

        // Find last batch for the prefix and sample type
        $lastBatch = batchModel::where('sample_type', $sampleType->id)
            ->where('batch_no', 'like', $prefix . '%')
            ->orderBy('batch_no', 'desc')
            ->first();

        $count = $lastBatch ? (int)substr($lastBatch->batch_no, -3) : 0;

        $batchNo = $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        return $batchNo;
    }

    public function createBatch(Request $request)
    {
        $request->validate([
            'sample_ids' => 'required|array',
            'sample_ids.*' => 'exists:sample,id',
        ]);

        // Fetch accepted samples and their buffers
        $samples = sampleModel::with('sampleType')
            ->with('buffer') // Ensure relationship exists
            ->whereIn('id', $request->sample_ids)
            ->where('sample_status', 'accepted')
            ->get();
        $sampleTypes = $samples->pluck('sampleType')->unique();
        if ($sampleTypes->count() > 1) {
            return back()->withErrors(['Samples must all be of the same type.']);
        }

        $sampleType = sampleTypeModel::findOrFail($sampleTypes->first()->id);
        // Create batch
        $batchNumber = $this->generateNextBatchNumber($sampleType);
        $batch = batchModel::create([
            'batch_no' => $batchNumber,
            'sample_type' => $sampleType->id,
            'date' => now(),
            'sample_no' => $samples->count(),
            'batch_status' => 'manual',
        ]);

        // Assign lab ref and clean up samples
        foreach ($samples as $index => $sample) {
            labRefModel::create([
                'sample_id' => $sample->id,
                'batch_no' => $batch->batch_no,
                'lab_ref_no' => $index + 1,
            ]);
            $sample->update(['batch_id' => $batch->id]);

            // 🚫 Remove sample from buffer
            sampleBufferModel::where('sample_id', $sample->id)->delete();
        }

        return back()->with('success', 'Batch created manually.');
    }
}
