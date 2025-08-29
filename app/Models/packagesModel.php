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
        return $this->belongsTo(SampleTypeModel::class, 'sample_type_id');
    }
    public function parameters()
    {
        return $this->belongsToMany(IndividualParameterModel::class, 'package_parameters', 'package_id', 'parameter_id');
    }
}
