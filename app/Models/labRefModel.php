<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labRefModel extends Model
{
     use HasFactory;
     protected $table = 'lab_refrence';

    protected $fillable = [
        'sample_id',
        'batch_no',
        'lab_ref_no',
    ];
}
