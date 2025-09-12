<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class concernModel extends Model
{
     use HasFactory;
     protected $table = 'concern';

    protected $fillable = [
        'sample_type',
        'concern',
    ];
}
