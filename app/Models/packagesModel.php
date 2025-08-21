<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packagesModel extends Model
{
     use HasFactory;
     protected $table = 'packages';

    protected $fillable = [
        'package_name',
        'sample_type',
        'price',
        'parameters',
    ];
}
