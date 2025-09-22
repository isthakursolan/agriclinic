<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class investigationsModel extends Model
{
     use HasFactory;
     protected $table = 'investigations';

    protected $fillable = [
        'sample_id',
        'parameter',
        'reading1',
        'reading2',
        'dilusion',
        'verify_entry',
        'result',
        'interpretation',
    ];
     public function sample()
    {
        return $this->belongsTo(sampleModel::class, 'sample_id');
    }

    public function parameters()
    {
        return $this->belongsTo(individualParameterModel::class, 'parameter');
    }

}
