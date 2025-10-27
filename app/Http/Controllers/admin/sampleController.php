<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\activecropModel;
use App\Models\fieldModel;
use App\Models\paymentsModel;
use App\Models\sampleModel;
use App\Models\sampleTypeModel;
use Illuminate\Http\Request;

class sampleController extends Controller
{
    public function index()
    {
        $samples = SampleModel::with(['payments', 'sampleType', 'package'])
            ->orderBy('created_at', 'desc')
            ->get();
        $field = fieldModel::get();
        $crop = activecropModel::get();
        $type = sampleTypeModel::get();
        // echo $samples;
        return view('admin.samples.index', compact('samples', 'field', 'crop', 'type'));
    }
    public function details($id)
    {
        // echo "Details coming soon for sample id: " . $id;
        $farmer_id =sampleModel::where('id', $id)->value('farmer_id');
        $sample = sampleModel::with(['farmer', 'crop', 'field', 'investigations.parameters'])
            ->where('farmer_id', $farmer_id)
            ->findOrFail($id);

        $payment = paymentsModel::whereJsonContains('sample_id', $id)->first();

        return view('admin.samples.details', compact('sample', 'payment'));
    }
}
