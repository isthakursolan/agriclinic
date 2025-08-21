<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampleModel extends Model
{
     use HasFactory;
     protected $table = 'sample';

    protected $fillable = [
        'sample_id',
        'farmer_id',
        'field_id',
        'crop_id',
        'concern',
        'sample_type',
        'collection_method',
        'quantity',
        'package',
        'amount',
        'sample_status',
        'verify_payment',
    ];
}
