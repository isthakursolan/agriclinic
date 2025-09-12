<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\profileModel;
use App\Models\sampleModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class frontofficeController extends Controller
{
    public function index()
    {

        // Stats for today
        $today = Carbon::today();

        $newFarmersToday = profileModel::whereHas('user', function ($query) {
            $query->role('farmer');
        })->whereDate('created_at', $today)->count();

        $samplesReceivedToday = sampleModel::whereDate('created_at', $today)->count();

        // Recent Activities
        $recentSamples = sampleModel::with(['farmer', 'sampleType', 'payments'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Farmers with pending actions (e.g., incomplete profiles or pending payments)
        $farmersWithPendingActions = profileModel::whereHas('user', function ($query) {
            $query->role('farmer');
        })
        ->whereHas('samples', function ($query) {
            $query->where(function ($q) {
                $q->where('sample_status', 'pending')->orWhereNull('sample_status');
            });
        })
        ->limit(10)
        ->get();

        return view('frontoffice.dashboard', compact(
            'newFarmersToday',
            'samplesReceivedToday',
            'recentSamples',
            'farmersWithPendingActions'
        ));
    }
}
