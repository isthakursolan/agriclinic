<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\investigationsModel;
use App\Models\sampleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class analystResultController extends Controller
{
    public function index()
    {
        $samples = sampleModel::with(['investigations.parameters', 'investigations' => function ($query) {
            $query->whereNotNull('result');
        }])->get();

        $samples->each(function ($sample) {
            // 1️⃣ Count total expected investigations for this sample_id
            $expectedCount = investigationsModel::where('sample_id', $sample->id)->count();
            // 2️⃣ Count how many investigations this sample actually has
            $actualCount = $sample->investigations->count();
            // 3️⃣ Check if all exist and all are verified
            $sample->has_all_investigations = ($expectedCount > 0 && $actualCount === $expectedCount);
            // 4️⃣ Check if all investigations are verified
            $sample->all_verified = $sample->has_all_investigations &&
                $sample->investigations->every(function ($investigation) {
                    return (bool) $investigation->verify_entry;
                });
        });
        // echo $samples;
        return view('analyst.verify.index', compact('samples'));
    }
    public function update(Request $request, $id)
    {
        $result = investigationsModel::findOrFail($id);

        $validated = $request->validate([
            'parameter_value' => 'required|numeric',
            'remarks' => 'nullable|string|max:255'
        ]);

        $result->update($validated);

        return redirect()->route('analyst.results.index')
            ->with('success', 'Result updated successfully');
    }

    public function verify($id)
    {
        $result = investigationsModel::findOrFail($id);
        $result->update([
            'verify_entry' => 1,
            'verify_by' => Auth::id()
        ]);

        return redirect()->route('analyst.verification.index')
            ->with('success', 'Result verified successfully');
    }
    public function showReport($sample_id)
    {
        $sample = sampleModel::with('investigations')->findOrFail($sample_id);
        return view('analyst.report.show', compact('sample'));
    }
    public function reports()
    {
        $samples = sampleModel::with(['investigations.parameters', 'investigations' => function ($query) {
            $query->whereNotNull('result');
        }])->get();
        return view('analyst.report.index', compact('samples'));
    }
}
