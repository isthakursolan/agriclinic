<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentReport extends Model
{
     use HasFactory;
    protected $table = 'agent_reports';
    protected $fillable = [
        'task_id',
        'field_agent_id',
        'notes',
        'attachments',
        'submitted_at',
        'status',
        'rejection_reason',
        'reviewed_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(agentTask::class, 'task_id');
    }

    public function fieldAgent()
    {
        return $this->belongsTo(User::class, 'field_agent_id');
    }
}
