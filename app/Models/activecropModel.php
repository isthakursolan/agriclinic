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
        return $this->belongsTo(User::class, 'farmer_id');
    }
}
