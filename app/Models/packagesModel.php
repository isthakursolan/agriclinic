<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packagesModel extends Model
{
    use HasFactory;
    protected $table = 'packages';

    protected $fillable = [
        'package_name',
        'reporting_time',
        'sample_type',
        'price',
        'parameters',
    ];
    public function sampleType()
    {
        return $this->belongsTo(sampleTypeModel::class, 'sample_type');
    }
    public function parameters()
    {
        return $this->belongsToMany(individualParameterModel::class, 'package_parameters', 'package_id', 'parameter_id');
    }
}
