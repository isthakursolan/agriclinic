<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rootstockModel extends Model
{
     use HasFactory;
     protected $table = 'rootstock';

    protected $fillable = [
        'crop',
        'rootstock',
    ];
     public function crops()
    {
        return $this->belongsTo(cropModel::class,'crop');
    }
}
