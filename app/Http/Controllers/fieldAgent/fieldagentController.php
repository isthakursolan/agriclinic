<?php

namespace App\Http\Controllers\fieldAgent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\agentTask;
use App\Models\agentReport;
use App\Models\FieldAgentAssignment;
use App\Models\fieldModel;
use App\Models\profileModel;

class fieldagentController extends Controller
{
    public function index()
    {
        $agent = Auth::user();

        // Get assigned farmers count
        $assignedFarmersCount = FieldAgentAssignment::where('field_agent_id', $agent->id)
            ->where('assignment_type', 'farmer')
            ->distinct('farmer_id')
            ->count();

        // Get total tasks
        $totalTasks = agentTask::where('field_agent_id', $agent->id)->count();

        // Get pending tasks
        $pendingTasks = agentTask::where('field_agent_id', $agent->id)
            ->where('status', 'pending')
            ->count();

        // Get completed tasks
        $completedTasks = agentTask::where('field_agent_id', $agent->id)
            ->where('status', 'completed')
            ->count();

        // Get overdue tasks
        $overdueTasks = agentTask::where('field_agent_id', $agent->id)
            ->where('status', '!=', 'completed')
            ->where('due_date', '<', now())
            ->count();

        // Get recent tasks (upcoming or due soon)
        $recentTasks = agentTask::where('field_agent_id', $agent->id)
            ->where('status', '!=', 'completed')
            ->with(['farmer', 'field'])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Get recent reports
        $recentReports = agentReport::where('field_agent_id', $agent->id)
            ->with(['task.farmer', 'task.field'])
            ->orderBy('submitted_at', 'desc')
            ->limit(5)
            ->get();

        // Efficiently count fields assigned to the agent through their farmers
        $assignedFarmerIds = FieldAgentAssignment::where('field_agent_id', $agent->id)
            ->where('assignment_type', 'farmer')
            ->distinct()
            ->pluck('farmer_id');

        $fieldsCount = fieldModel::whereIn('farmer_id', $assignedFarmerIds)->count();

        return view('agent.dashboard', compact(
            'assignedFarmersCount',
            'totalTasks',
            'pendingTasks',
            'completedTasks',
            'overdueTasks',
            'recentTasks',
            'recentReports',
            'fieldsCount'
        ));
    }
}
