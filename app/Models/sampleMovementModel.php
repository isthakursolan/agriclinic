<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampleMovementModel extends Model
{
     use HasFactory;
     protected $table = 'sample_movement';

    protected $fillable = [
        'sample_id',
        'timestamp',
        'user_id',
        'action',
        'target',
        'method',
        'mode',
        'picture',
    ];
}
