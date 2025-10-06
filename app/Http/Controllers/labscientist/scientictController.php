<?php

namespace App\Http\Controllers\labscientist;

use App\Http\Controllers\Controller;
use App\Models\batchModel;
use App\Models\investigationsModel;
use App\Models\sampleModel;
use Illuminate\Http\Request;

class scientictController extends Controller
{
    public function index()
    {
        $totalInvestigations = investigationsModel::count();
        $pendingInvestigations = investigationsModel::where('verify_entry', '')->count();
        $investigationProgress = $totalInvestigations > 0 ?
            (($totalInvestigations - $pendingInvestigations) / $totalInvestigations) * 100 : 0;

        // $totalReports = report::count();
        // $completedReports = report::where('status', 'completed')->count();
        $totalReports=20;
        $completedReports="10";
        $reportProgress = $totalReports > 0 ? ($completedReports / $totalReports) * 100 : 0;

        return view('labscientist.dashboard', [
            'batchCount' => batchModel::count(),
            'pendingInvestigations' => $pendingInvestigations,
            'investigationProgress' => $investigationProgress,
            'completedReports' => $completedReports,
            'reportProgress' => $reportProgress,
            'urgentSamples' => sampleModel::where('sample_status', 'accepted')->count(),
            // 'recentActivities' => Activity::latest()->take(5)->get(),
            'weeklyLabels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'weeklyData' => ['2', '4', '6', '5', '1', '7', '1'],

            // 'weeklyData' => Report::weeklyCompletedCount()
        ]);
    }
}
