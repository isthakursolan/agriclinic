<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fieldModel extends Model
{
    use HasFactory;

    // Use your existing table name
    protected $table = 'field'; // Your actual table name

    protected $fillable = [
        'farmer_id',
        'field_name',
        'field_area',
        'land_profile',
        'road_connectivity',
        'type_of_field',
        'irrigation_system',
        'source_of_irrigation',
        'soil_type',
        'field_latitude',
        'field_longitude',
        'field_boundary',
        'description',
        'map_image',
    ];

    protected $casts = [
        'field_area' => 'decimal:2',
    ];

    public function farmer()
    {
        return $this->belongsTo(profileModel::class, 'farmer_id');
    }

    // Create a location attribute from your existing fields
    public function getLocationAttribute()
    {
        return $this->land_profile ?? 'Not specified';
    }

    // Create crops accessor (since you don't have crop fields in this table)
    public function getCropsAttribute()
    {
        // Since your table doesn't have crop fields, return empty collection
        // You might want to create a separate relationship table later
        return collect();
    }

    // Alternative: if you want to add crop info, you could use description field
    public function getCropInfoAttribute()
    {
        return $this->description ?? 'No crop information available';
    }

    public function tasks()
    {
        return $this->hasMany(agentTask::class, 'field_id');
    }

    public function samples()
    {
        return $this->hasMany(sampleModel::class, 'field_id');
    }

    public function assignments()
    {
        return $this->hasMany(FieldAgentAssignment::class, 'field_id');
    }
     public function crops()
    {
        return $this->hasMany(activecropModel::class, 'plot_id'); // adjust foreign key if needed
    }
    public function lastcrop()
    {
        return $this->hasOne(activecropModel::class, 'plot_id')->latestOfMany();
    }
}
