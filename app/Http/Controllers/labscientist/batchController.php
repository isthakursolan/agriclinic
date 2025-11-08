<?php

namespace App\Http\Controllers\labscientist;

use App\Http\Controllers\Controller;
use App\Models\batchModel;
use App\Models\individualParameterModel;
use App\Models\investigationsModel;
use App\Models\labRefModel;
use Illuminate\Http\Request;

class batchController extends Controller
{
    public function index()
    {
        $batches = batchModel::get();
        // $samples = labRefModel::with('sample', 'sample.sampleType')->get();
        return view('labscientist.batches.index', compact('batches'));
    }
    public function show($id)
    {
        $batch = batchModel::where('id', $id)->first();
        $samples = labRefModel::with('sample', 'sample.sampleType')
            ->where('batch_no', $batch->batch_no)
            ->get();

        foreach ($samples as $labRef) {
            $sample = $labRef->sample;
            if ($sample && !empty($sample->parameters)) {
                $sample->parameter_names = individualParameterModel::whereIn('id', $sample->parameters)
                    ->pluck('parameter')
                    ->implode(', ');
            }
        }

        return view('labscientist.batches.show', compact('samples', 'batch'));
    }

    public function parameters($id)
    {
        $batch = batchModel::where('id', $id)->with('sampleType')->first();
        $parameters = individualParameterModel::where('sample_type', $batch->sample_type)->get();
        $samples = labRefModel::with('sample', 'sample.sampleType')->where('batch_no', $batch->batch_no)->get();
        $parameterCounts = [];
        foreach ($samples as $labRef) {
            $sample = $labRef->sample;

            if ($sample && !empty($sample->parameters)) {
                foreach ($sample->parameters as $parameterId) {
                    if (!isset($parameterCounts[$parameterId])) {
                        $parameterCounts[$parameterId] = 0;
                    }
                    $parameterCounts[$parameterId]++;
                }
            }
        }

        foreach ($parameters as $parameter) {
            $parameter->sample_count = $parameterCounts[$parameter->id] ?? 0;
        }

        $parametersWithCount = $parameters->map(function ($parameter) {
            return [
                'id' => $parameter->id,
                'parameter' => $parameter->parameter,
                'sample_count' => $parameter->sample_count
            ];
        })->toArray();

        return view('labscientist.batches.parameters', compact('batch', 'parameters', 'samples', 'parametersWithCount'));
    }
    public function paramView($paramId, $batchId)
    {
        $parameter = individualParameterModel::findOrFail($paramId);
        $batch = batchModel::with('sampleType')->where('batch_no', $batchId)->first();

        // Get all samples from this batch that have this parameter
        $samples = labRefModel::with(['sample', 'sample.investigations' => function ($query) use ($paramId) {
            $query->where('parameter', $paramId);
        }])
            ->where('batch_no', $batch->batch_no)
            ->whereHas('sample.investigations', function ($query) use ($paramId) {
                $query->where('parameter', $paramId);
            })
            ->get();
        // echo $samples;
        return view('labscientist.parameters.view', compact('parameter', 'batch', 'samples'));
    }

    public function paramEdit($paramId, $sampleId)
    {
        $parameter = individualParameterModel::findOrFail($paramId);
        // Get all samples from this batch that have this parameter
        $samples = labRefModel::with(['sample', 'sample.investigations' => function ($query) use ($paramId) {
            $query->where('parameter', $paramId);
        }])
            ->whereHas('sample.investigations', function ($query) use ($paramId) {
                $query->where('parameter', $paramId);
            })
            ->where('sample_id', $sampleId)
            ->get();
        $investigation = investigationsModel::where('sample_id', $sampleId)->where('parameter', $paramId)->first();
        // echo $investigation;
        return view('labscientist.parameters.edit', compact('parameter', 'samples', 'investigation'));
    }
    public function paramUpdate($id, Request $request)
    {
        $data = request()->validate([
            'reading1' => 'required|string',
            'reading2' => 'nullable|string',
            'dilusion' => 'nullable|string',
            'result' => 'nullable|string',
            'interpretation' => 'nullable|string',
        ]);

        $investigation = investigationsModel::findOrFail($id);
        $investigation->reading1 = $data['reading1'];
        $investigation->reading2 = $data['reading2'];
        $investigation->dilusion = $data['dilusion'];
        $investigation->result = $data['result'];
        $investigation->interpretation = $data['interpretation'];
        $investigation->save();

        return redirect()->back()->with('success', 'Investigation updated successfully.');
    }
    public function resultView($paramId, $sampleId)
    {
        $parameter = individualParameterModel::findOrFail($paramId);
        // Get all samples from this batch that have this parameter
        $samples = labRefModel::with(['sample', 'sample.investigations' => function ($query) use ($paramId) {
            $query->where('parameter', $paramId);
        }])
            ->whereHas('sample.investigations', function ($query) use ($paramId) {
                $query->where('parameter', $paramId);
            })
            ->where('sample_id', $sampleId)
            ->get();
        $investigation = investigationsModel::where('sample_id', $sampleId)->where('parameter', $paramId)->first();
        // echo $investigation;
        return view('labscientist.parameters.result-view', compact('parameter', 'samples', 'investigation'));
    }
    public function investigations()
    {
        $investigations = investigationsModel::with('sample', 'sample.sampleType', 'parameters')->get();
        // echo $investigations;
        return view('labscientist.investigations.index', compact('investigations'));
    }
    public function bulkUpdate(Request $request)
    {
        $data = $request->input('data', []);
        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No data received.']);
        }

        $allowedFields = ['reading1', 'reading2', 'dilusion', 'result', 'interpretation'];
        $updatedCount = 0;

        foreach ($data as $item) {
            if (!isset($item['id'], $item['field'], $item['value'])) continue;
            if (!in_array($item['field'], $allowedFields)) continue;

            $inv = \App\Models\investigationsModel::find($item['id']);
            if ($inv) {
                $inv->{$item['field']} = $item['value'];
                $inv->save();
                $updatedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "$updatedCount record(s) updated successfully."
        ]);
    }
}
