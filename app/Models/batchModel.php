<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batchModel extends Model
{
     use HasFactory;
     protected $table = 'batch';

    protected $fillable = [
        'batch_no',
        'sample_type',
        'date',
        'sample_no',
        'batch_status',
    ];
     public function sampleType()
    {
        return $this->belongsTo(sampleTypeModel::class, 'sample_type');
    }
}
