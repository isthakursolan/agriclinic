<?php

namespace App\Http\Controllers\analyst;

use App\Http\Controllers\Controller;
use App\Models\investigationsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class analystResultController extends Controller
{
    public function index()
    {
        $investigations = investigationsModel::with('sample', 'sample.sampleType', 'parameters')->whereNot('result', null)->get();
        // echo $investigations;
        return view('analyst.verify.index', compact('investigations'));
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
            'verify_by' =>Auth::id()
        ]);

        return redirect()->route('analyst.verification.index')
            ->with('success', 'Result verified successfully');
    }
}
