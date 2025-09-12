<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldAgentAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_agent_id',
        'farmer_id',
        'field_id',
        'assignment_type',
        'status',
        'assigned_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function fieldAgent()
    {
        return $this->belongsTo(User::class, 'field_agent_id');
    }

    public function farmer()
    {
        return $this->belongsTo(profileModel::class, 'farmer_id');
    }

    public function field()
    {
        return $this->belongsTo(fieldModel::class, 'field_id');
    }

    public function tasks()
    {
        return $this->hasMany(agentTask::class, 'assignment_id');
    }
}
