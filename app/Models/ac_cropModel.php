<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ac_cropModel extends Model
{
     use HasFactory;
     protected $table = 'activecrop';

    protected $fillable = [
        'name',
        'farmer_id',
        'plot_id',
        'type_of_crop',
        'variety',
        'rootstock',
        'sowing_date',
        'expected_harvest_date',
        'fertilizer_plan',
        'photo',
        'description',
    ];
}
