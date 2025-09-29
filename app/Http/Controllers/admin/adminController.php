<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\activecropModel;
use App\Models\agentReport;
use App\Models\fieldModel;
use App\Models\paymentsModel;
use App\Models\sampleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'farmers' => User::whereHas('roles', fn($q) => $q->where('name', 'farmer'))->count(),
                'agents' => User::whereHas('roles', fn($q) => $q->where('name', 'field_agent'))->count()
            ],
            'active_crops' => activecropModel::count(),
            'fields' => fieldModel::count(),
            'samples' => [
                'total' => sampleModel::count(),
                'pending' => sampleModel::where('sample_status', 'pending')->count(),
                'processing' => sampleModel::where('sample_status', 'processing')->count(),
                'completed' => sampleModel::where('sample_status', 'completed')->count()
            ],
            'payments' => [
                'total' => paymentsModel::sum('amount'),
                'pending' => paymentsModel::where('confirm_payment', false)->sum('amount'),
                'completed' => paymentsModel::where('confirm_payment', true)->sum('amount')
            ],
            'reports' => agentReport::count(),
            // 'recent_activities' => Activity::latest()->take(5)->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
