<?php

namespace App\Http\Controllers\fieldAgent;

use App\Http\Controllers\Controller;
use App\Models\agentReport;
use App\Models\agentTask;
use App\Models\FieldAgentAssignment;
use App\Models\fieldModel;
use App\Models\profileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class farmerAgentController extends Controller
{
    // Show assigned farmers
    public function farmers()
    {
        $agent = Auth::user();

        $assignments = FieldAgentAssignment::where('field_agent_id', $agent->id)
            ->where('assignment_type', 'farmer')
            ->with(['farmer.user', 'farmer.fields'])
            ->get();

        return view('agent.farmers.index', compact('assignments'));
    }

    // Show specific farmer details
    public function showFarmer($farmerId)
    {
        $agent = Auth::user();
        $farmer = profileModel::with(['user', 'fields', 'assignedAgents'])
            ->findOrFail($farmerId);

        // Check if this farmer is assigned to current agent
        $assignment = FieldAgentAssignment::where('field_agent_id', $agent->id)
            ->where('farmer_id', $farmerId)
            ->first();

        if (!$assignment) {
            abort(403, 'You are not assigned to this farmer.');
        }

        // Get tasks for this farmer
        $tasks = agentTask::where('field_agent_id', $agent->id)
            ->where('farmer_id', $farmerId)
            ->with(['field', 'reports'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('agent.farmers.show', compact('farmer', 'tasks', 'assignment'));
    }

    // Show fields assigned to agent
    public function fields()
    {
        $agent = Auth::user();

        try {
            // Get fields through farmer assignments
            $assignments = FieldAgentAssignment::where('field_agent_id', $agent->id)
                ->with(['farmer.fields'])
                ->get();

            $fields = collect();
            foreach ($assignments as $assignment) {
                if ($assignment->farmer && $assignment->farmer->fields) {
                    $fields = $fields->merge($assignment->farmer->fields);
                }
            }

            return view('agent.fields.index', compact('fields'));

        } catch (\Exception $e) {
            // Handle database errors gracefully
            $fields = collect();
            return view('agent.fields.index', compact('fields'))->with('error', 'There was an issue loading fields data. Please contact your administrator.');
        }
    }

    // Show specific field details
    public function showField($fieldId)
    {
        $agent = Auth::user();
        $field = fieldModel::with(['farmer', 'crops'])->findOrFail($fieldId);

        // Check if agent has access to this field through farmer assignment
        $hasAccess = FieldAgentAssignment::where('field_agent_id', $agent->id)
            ->where('farmer_id', $field->farmer_id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have access to this field.');
        }

        // Get tasks for this field
        $tasks = agentTask::where('field_agent_id', $agent->id)
            ->where('field_id', $fieldId)
            ->with(['reports'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('agent.fields.show', compact('field', 'tasks'));
    }

    // Show agent's tasks
    public function tasks()
    {
        $agent = Auth::user();

        $tasks = agentTask::where('field_agent_id', $agent->id)
            ->with(['farmer', 'field', 'reports'])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('agent.tasks.index', compact('tasks'));
    }

    // Show the form to create a report for a task
    public function createReport(agentTask $task)
    {
        $agent = Auth::user();
        // Ensure agent can only create reports for their own tasks
        if ($task->field_agent_id !== $agent->id) {
            abort(403, 'You are not authorized to report on this task.');
        }
        return view('agent.reports.create', compact('task'));
    }

    // Store the report and complete the task
    public function storeReport(Request $request, agentTask $task)
    {
        $agent = Auth::user();
        // Ensure agent can only store reports for their own tasks
        if ($task->field_agent_id !== $agent->id) {
            abort(403, 'You are not authorized to report on this task.');
        }

        $request->validate([
            'notes' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $attachmentPaths[] = $file->store('agent_reports', 'public');
            }
        }

        agentReport::create([
            'task_id' => $task->id,
            'field_agent_id' => $agent->id,
            'notes' => $request->notes,
            'attachments' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null,
            'submitted_at' => now(),
        ]);

        // Update the task status to 'completed'
        $task->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('agent.reports')->with('success', 'Report submitted successfully! The task is now pending review.');
    }

    // Mark task as in progress
    public function startTask($taskId)
    {
        $agent = Auth::user();
        $task = agentTask::where('field_agent_id', $agent->id)->findOrFail($taskId);

        $task->update(['status' => 'in_progress']);

        return redirect()->back()->with('success', 'Task marked as in progress.');
    }

    // Show agent's reports
    public function reports()
    {
        $agent = Auth::user();

        $reports = agentReport::where('field_agent_id', $agent->id)
            ->with(['task.farmer', 'task.field'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('agent.reports.index', compact('reports'));
    }

    // Show specific report
    public function showReport($reportId)
    {
        $agent = Auth::user();
        $report = agentReport::where('field_agent_id', $agent->id)
            ->with(['task.farmer', 'task.field'])
            ->findOrFail($reportId);

        return view('agent.reports.show', compact('report'));
    }

    // Edit report (if allowed)
    public function editReport($reportId)
    {
        $agent = Auth::user();
        $report = agentReport::where('field_agent_id', $agent->id)
            ->with(['task.farmer', 'task.field'])
            ->findOrFail($reportId);

        // Only allow editing if the report is pending or has been rejected.
        if ($report->status === 'approved') {
            return redirect()->route('agent.reports')->with('error', 'Cannot edit an approved report.');
        }

        return view('agent.reports.edit', compact('report'));
    }

    // Update report
    public function updateReport(Request $request, $reportId)
    {
        $agent = Auth::user();
        $report = agentReport::where('field_agent_id', $agent->id)->findOrFail($reportId);

        $request->validate([
            'notes' => 'required|string|min:10',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120'
        ]);

        // Handle new file uploads
        $attachmentPaths = $report->attachments ? json_decode($report->attachments, true) : [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('agent_reports', 'public');
                $attachmentPaths[] = $path;
            }
        }

        // Update report
        $report->update([
            'notes' => $request->notes,
            'attachments' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null,
            'submitted_at' => now(),
        ]);

        return redirect()->route('agent.reports')->with('success', 'Report updated successfully!');
    }

    // Delete attachment from report
    public function deleteAttachment($reportId, $attachmentIndex)
    {
        $agent = Auth::user();
        $report = agentReport::where('field_agent_id', $agent->id)->findOrFail($reportId);

        $attachments = json_decode($report->attachments, true) ?? [];

        if (isset($attachments[$attachmentIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($attachments[$attachmentIndex]);

            // Remove from array
            unset($attachments[$attachmentIndex]);
            $attachments = array_values($attachments); // Reindex array

            // Update report
            $report->update([
                'attachments' => !empty($attachments) ? json_encode($attachments) : null
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
