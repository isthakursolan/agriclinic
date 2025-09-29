<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\batchModel;
use App\Models\individualParameterModel;
use App\Models\labRefModel;
use App\Models\packagesModel;
use App\Models\sampleModel;
use App\Models\sampleTypeModel;
use Illuminate\Database\Eloquent\Collection;

class batchController extends Controller
{
    public function batchView($id)
    {
        $batch = batchModel::where('id', $id)->first();
        $samples = labRefModel::with('sample', 'sample.sampleType')->where('batch_no', $batch->batch_no)->get();
        // $samples = sampleModel::with('sampleType','labref')->get();
        foreach ($samples as $labRef) {           // loop collection
            $sample = $labRef->sample;            // get related sample

            if ($sample && !empty($sample->parameters)) {
                $sample->parameter_names = individualParameterModel::whereIn('id', $sample->parameters)
                    ->pluck('parameter')
                    ->implode(', ');
            }
        }
        return view('frontoffice.batches.batch-view', compact('samples', 'batch'));
    }
    public function batchParameters($id)
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
        return view('frontoffice.batches.batch-parameters', compact('batch', 'parameters', 'samples', 'parametersWithCount'));
    }
  public function paramView($paramId,$batchId)
    {
        $parameter = individualParameterModel::findOrFail($paramId);
        $batch = batchModel::with('sampleType')->where('batch_no', $batchId)->first();

        // Get all samples from this batch that have this parameter
        $samples = labRefModel::with(['sample', 'sample.investigations' => function($query) use ($paramId) {
                $query->where('parameter', $paramId);
            }])
            ->where('batch_no', $batch->batch_no)
            ->whereHas('sample.investigations', function($query) use ($paramId) {
                $query->where('parameter', $paramId);
            })
            ->get();

        return view('frontoffice.batches.parameters-view', compact('parameter', 'samples', 'batch'));
    }
    public function paramPrint($id)
    {
        $batch = BatchModel::findOrFail($id);
        return view('frontoffice.batches.print-view', compact('batch'));
    }
    public function printParameters($batchId)
    {
        $batch = BatchModel::with(['samples.parameters'])->findOrFail($batchId);
        return view('frontoffice.batches.print-view', [
            'batch' => $batch,
            'printMode' => true // Add this flag
        ]);
    }
}
