<?php

namespace App\Http\Controllers\farmer;

use App\Http\Controllers\Controller;
use App\Models\investigationsModel;
use App\Models\packagesModel;
use App\Models\paymentsModel;
use App\Models\sampleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends Controller
{
    public function show()
    {
        $id = session('id');
        $sample = sampleModel::where('farmer_id', $id)
            ->where('sample_status', 'pending')
            ->get();

        $totalAmount = $sample->sum('amount');

        return view('farmer.sample.paymentShow', compact('sample', 'totalAmount', 'id'));
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

            return redirect()->route('user.sample')
                ->with('success', 'Payment successful! Samples updated and investigations created.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        // return redirect()->route('user.sample')->with('success', 'Payment confirmed and investigations created!');
    }
}
