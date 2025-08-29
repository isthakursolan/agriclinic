<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampleTypeModel extends Model
{
     use HasFactory;
     protected $table = 'sample_type';

    protected $fillable = [
        'e_type',
        'h_type',
        'sample_size',
        'buffer_size',
        'batch_prefix',
    ];
     public function parameters()
    {
        return $this->hasMany(individualParameterModel::class, 'sample_type');
    }

    public function packages()
    {
        return $this->hasMany(packagesModel::class, 'sample_type');
    }
}
