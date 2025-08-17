<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fieldModel extends Model
{
    use HasFactory;
 protected $table = 'field';

    protected $fillable = [
        'id',
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
        'road_connectivity' => 'boolean',
        'irrigation_system' => 'boolean',
    ];
}
