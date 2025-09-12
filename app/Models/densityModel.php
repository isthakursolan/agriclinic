<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class densityModel extends Model
{
     use HasFactory;
     protected $table = 'density';

    protected $fillable = [
        'crop',
        'e_density',
        'h_density',
        'row_to_row',
        'plant_to_plant',
    ];
}
