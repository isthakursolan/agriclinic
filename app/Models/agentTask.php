<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agentTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_agent_id',
        'farmer_id',
        'field_id',
        'title',
        'description',
        'status',
        'due_date',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
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

    public function reports()
    {
        return $this->hasMany(agentReport::class, 'task_id');
    }
}
