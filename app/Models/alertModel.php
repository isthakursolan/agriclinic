<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alertModel extends Model
{
     use HasFactory;
     protected $table = 'alert';

    protected $fillable = [
        'sample_id',
        'movement_id',
        'user_id',
        'message',
        'status',
    ];
}
