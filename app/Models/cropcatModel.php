<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cropcatModel extends Model
{
     use HasFactory;
     protected $table = 'crop_cat';

    protected $fillable = [
        'e_cat',
        'h_cat',
    ];
     public function crops()
    {
        return $this->hasMany(cropModel::class, 'cat');
    }

}
