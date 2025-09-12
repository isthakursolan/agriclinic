<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'parameters',
        'amount',
        'sample_status',
        'verify_payment',
    ];
    // Relations
    protected $casts = [
        'parameters' => 'array',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sample) {

            // Use auto increment id (next id)
            $nextId = DB::table('sample')->max('id') + 1;

            $sample->sample_id = $nextId;
        });
    }
    public function sampleType()
    {
        return $this->belongsTo(SampleTypeModel::class, 'sample_type');
    }

    public function investigations()
    {
        return $this->hasMany(investigationsModel::class, 'sample_id');
    }

    public function payments()
    {
        return $this->hasMany(paymentsModel::class, 'sample_id');
    }
    public function farmer()
    {
        return $this->belongsTo(profileModel::class, 'farmer_id', 'id');
    }

    public function crop()
    {
        return $this->belongsTo(activecropModel::class, 'crop_id');
    }

    public function field()
    {
        return $this->belongsTo(fieldModel::class, 'field_id');
    }

    // public function sampleType()
    // {
    //     return $this->belongsTo(sampleTypeModel::class, 'sample_type_id');
    // }

    // public function package()
    // {
    //     return $this->belongsTo(Package::class, 'package_id');
    // }
    public function movements()
    {
        return $this->hasMany(sampleMovementModel::class, 'sample_id');
    }
}
