<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'contact',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // A User has one Profile
    public function profile()
    {
        return $this->hasOne(profileModel::class, 'user_id');
    }

    // A field agent can have many assignments
    public function assignments()
    {
        return $this->hasMany(FieldAgentAssignment::class, 'field_agent_id');
    }

    // A field agent can have many tasks
    public function agentTasks()
    {
        return $this->hasMany(agentTask::class, 'field_agent_id');
    }

    // A field agent can submit many reports
    public function reports()
    {
        return $this->hasMany(agentReport::class, 'field_agent_id');
    }

    // Field agent to farmers relationship (many-to-many) - Keep for backward compatibility
    public function farmers()
    {
        return $this->belongsToMany(User::class, 'farmer_agent', 'agent_id', 'farmer_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'farmer');
            });
    }

    // Farmer to field agents relationship (many-to-many) - Keep for backward compatibility
    public function agents()
    {
        return $this->belongsToMany(User::class, 'farmer_agent', 'farmer_id', 'agent_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'field_agent');
            });
    }
    public function fields()
    {
        return $this->hasMany(fieldModel::class, 'farmer_id', 'id');
    }

    public function activeCrops()
    {
        return $this->hasMany(activecropModel::class, 'farmer_id', 'id');
    }
}
