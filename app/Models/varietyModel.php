<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class varietyModel extends Model
{
     use HasFactory;
     protected $table = 'variety';

    protected $fillable = [
        'crop',
        'variety',
    ];
     public function crops()
    {
        return $this->belongsTo(cropModel::class,'crop');
    }
}
