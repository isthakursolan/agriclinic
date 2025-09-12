<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activecropModel extends Model
{
     use HasFactory;
     protected $table = 'active_crop';

    protected $fillable = [
        'name',
        'farmer_id',
        'plot_id',
        'crop_cat',
        'variety',
        'rootstock',
        'sowing_date',
        'expected_harvest_date',
        'fertilizer_plan',
        'photo',
        'description',
    ];
      // Relations
    public function farmer()
    {
        return $this->belongsTo(profileModel::class, 'farmer_id');
    }
     public function crop() {
        return $this->belongsTo(cropModel::class, 'crop_id');
    }
    public function plot() {
        return $this->belongsTo(fieldModel::class, 'plot_id');
    }
     public function field()
    {
        return $this->belongsTo(fieldModel::class, 'plot_id');
    }
}
