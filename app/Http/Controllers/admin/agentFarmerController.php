<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\profileModel;
use App\Models\User;
use App\Models\agentTask;
use App\Models\fieldModel;
use App\Models\FieldAgentAssignment;
use App\Models\agentReport;
use Illuminate\Http\Request;

class agentFarmerController extends Controller
{
    // Main index page showing all field agents with their tasks and farmers
    public function index()
    {
        $agents = User::role('field_agent')
            ->with([
                'profile',
                'agentTasks', // Just load tasks directly
                'assignments'
            ])
            ->get();

        // Add computed data for each agent
        foreach ($agents as $agent) {
            // Get farmers from assignments
            $agent->assignedFarmersCount = $agent->assignments()
                ->where('assignment_type', 'farmer')
                ->distinct('farmer_id')
                ->count();

            $assignedFarmerIds = $agent->assignments()
                ->where('assignment_type', 'farmer')
                ->pluck('farmer_id');
            $agent->fieldsCount = fieldModel::whereIn('farmer_id', $assignedFarmerIds)->count();

            // Task counts - Use query instead of collection filtering for accurate counts
            $agent->totalTasks = agentTask::where('field_agent_id', $agent->id)->count();
            $agent->pendingTasks = agentTask::where('field_agent_id', $agent->id)
                ->where('status', 'pending')
                ->count();
            $agent->completedTasks = agentTask::where('field_agent_id', $agent->id)
                ->where('status', 'completed')
                ->count();
            $agent->inProgressTasks = agentTask::where('field_agent_id', $agent->id)
                ->where('status', 'in_progress')
                ->count();
        }

        return view('admin.field_agents.index', compact('agents'));
    }

    public function assignForm()
    {
        $farmers = profileModel::whereHas('user', function($query) {
            $query->role('farmer');
        })->with('user')->get();
        $agents = User::role('field_agent')->with('profile')->get();

        // Don't load all fields here, load them via AJAX based on farmer selection

        return view('admin.field_agents.assign', compact('farmers', 'agents'));
    }

    public function assignFarmer(Request $request)
    {
        $request->validate([
            'farmer_id' => 'required|exists:profile,id', // Fixed table name
            'agent_id'  => 'required|exists:users,id',
        ]);

        // Create assignment record
        FieldAgentAssignment::create([
            'field_agent_id' => $request->agent_id,
            'farmer_id' => $request->farmer_id,
            'assignment_type' => 'farmer',
            'status' => 'active',
        ]);

        // Update pivot table
        $farmer = profileModel::find($request->farmer_id);
        $agent = profileModel::where('user_id', $request->agent_id)->first();

        if ($farmer && $agent) {
            $farmer->assignedAgents()->syncWithoutDetaching([$agent->id]);
        }

        return redirect()->route('admin.field-agents')->with('success', 'Farmer assigned to agent successfully');
    }

    public function getFieldsByFarmer($farmerId)
    {
        $fields = fieldModel::where('farmer_id', $farmerId)->get();
        return response()->json($fields);
    }

    // Create new task form
    public function createTask()
    {
        $agents = User::role('field_agent')->with('profile')->get();
        $farmers = profileModel::whereHas('user', function($query) {
            $query->role('farmer');
        })->with('user')->get();

        // Don't load all fields, load them based on farmer selection

        return view('admin.field_agents.create_task', compact('agents', 'farmers'));
    }

    // Store new task
    public function storeTask(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'field_agent_id' => 'required|exists:users,id',
            'farmer_id' => 'nullable|exists:profile,id', // Fixed table name
            'field_id' => 'nullable|exists:field,id', // Fixed table name
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:today',
        ]);

        agentTask::create([
            'field_agent_id' => $request->field_agent_id,
            'farmer_id' => $request->farmer_id,
            'field_id' => $request->field_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.field-agents')->with('success', 'Task assigned to field agent successfully');
    }

    // Edit task form
    public function editTask(agentTask $task)
    {
        $agents = User::role('field_agent')->with('profile')->get();
        $farmers = profileModel::whereHas('user', function($query) {
            $query->role('farmer');
        })->with('user')->get();
        $fields = fieldModel::with('farmer')->get();

        return view('admin.field_agents.edit_task', compact('task', 'agents', 'farmers', 'fields'));
    }

    // Update task
    public function updateTask(Request $request, agentTask $task)
    {
        $request->validate([
            'field_agent_id' => 'required|exists:users,id',
            'farmer_id' => 'nullable|exists:profile,id', // Fixed table name
            'field_id' => 'nullable|exists:field,id', // Fixed table name
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return redirect()->route('admin.field-agents')->with('success', 'Task updated successfully');
    }

    // Delete task
    public function destroyTask(agentTask $task)
    {
        $task->delete();
        return redirect()->route('admin.field-agents')->with('success', 'Task deleted successfully');
    }

    public function assignedFarmers()
    {
        $assignments = FieldAgentAssignment::with(['fieldAgent.profile', 'farmer.user'])
            ->where('assignment_type', 'farmer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.field_agents.list', compact('assignments'));
    }

    public function unassign($farmerId, $agentId)
    {
        // Remove from assignment table
        FieldAgentAssignment::where('farmer_id', $farmerId)
            ->where('field_agent_id', $agentId)
            ->delete();

        // Remove from pivot table
        $farmer = profileModel::find($farmerId);
        $agent = profileModel::where('user_id', $agentId)->first();

        if ($farmer && $agent) {
            $farmer->assignedAgents()->detach($agent->id);
        }

        return redirect()->back()->with('success', 'Farmer unassigned successfully');
    }

    public function tasksByAgent($agentId)
    {
        $agent = User::with('profile')->findOrFail($agentId);
        $tasks = agentTask::with(['farmer', 'field'])
            ->where('field_agent_id', $agentId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.field_agents.tasks', compact('agent', 'tasks'));
    }

    public function allReports()
    {
        $reports = agentReport::with([
            'task.farmer',
            'task.field',
            'fieldAgent.profile'
        ])
        ->orderBy('submitted_at', 'desc')
        ->get();

        return view('admin.field_agents.reports.index', compact('reports'));
    }

    public function showReport($reportId)
    {
        $report = agentReport::with([
            'task.farmer',
            'task.field',
            'fieldAgent.profile'
        ])->findOrFail($reportId);

        return view('admin.field_agents.reports.show', compact('report'));
    }

    public function approveReport(Request $request, $reportId)
    {
        $report = agentReport::findOrFail($reportId);

        // Update the report status
        $report->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        // Update the associated task status
        $report->task->update(['status' => 'completed', 'completed_at' => now()]);
        return redirect()->back()->with('success', 'Report approved and task marked as completed.');
    }

    public function rejectReport(Request $request, $reportId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $report = agentReport::findOrFail($reportId);

        // Update the report with rejection details
        $report->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_at' => now(),
        ]);

        // Re-open the task for the agent
        $report->task->update(['status' => 'in_progress']);
        return redirect()->back()->with('success', 'Report rejected. The agent has been notified to resubmit.');
    }

    public function reportsByAgent($agentId)
    {
        $agent = User::with('profile')->findOrFail($agentId);
        $reports = agentReport::with([
            'task.farmer',
            'task.field'
        ])
        ->where('field_agent_id', $agentId)
        ->orderBy('submitted_at', 'desc')
        ->get();

        return view('admin.field_agents.reports.by_agent', compact('agent', 'reports'));
    }
}
