<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class individualParameterModel extends Model
{
     use HasFactory;
     protected $table = 'individual_parameter';

    protected $fillable = [
        'parameter',
        'symbol',
        'reporting_time',
        'price',
        'sample_type',
        'reading_type',
    ];
     public function sampleType()
    {
        return $this->belongsTo(sampleTypeModel::class, 'sample_type');
    }

    public function packages()
    {
        return $this->belongsToMany(packagesModel::class, 'package_parameters', 'parameter_id', 'package_id');
    }

    public function investigations()
    {
        return $this->hasMany(investigationsModel::class, 'parameter');
    }
}
