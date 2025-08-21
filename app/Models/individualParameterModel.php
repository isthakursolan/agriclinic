<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class individualParameterModel extends Model
{
     use HasFactory;
     protected $table = 'individual_parameter';

    protected $fillable = [
        'parameter',
        'reporting_time',
        'price',
        'sample_type',
        'reading_type',
    ];
}
