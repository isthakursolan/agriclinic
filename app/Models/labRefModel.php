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
     public function sample()
    {
        return $this->hasOne(sampleModel::class, 'sample_id','sample_id');
    }
    public function batch()
    {
        return $this->belongsTo(batchModel::class, 'batch_no', 'batch_no');
    }
    public function investigations()
    {
        return $this->hasMany(investigationsModel::class, 'sample_id', 'sample_id');
    }
}
