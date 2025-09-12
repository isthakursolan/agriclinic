<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cropModel extends Model
{
     use HasFactory;
     protected $table = 'crop';

    protected $fillable = [
        'cat',
        'type',
        'crop',
        'rootstock',
        'variety',
        'aging',
    ];
    public function cropType()
    {
        return $this->belongsTo(croptypeModel::class, 'type');
    }
    public function category()
    {
        return $this->belongsTo(cropcatModel::class, 'cat');
    }
     public function varieties()
    {
        return $this->hasMany(varietyModel::class, 'crop');
    }
     public function rootstocks()
    {
        return $this->hasMany(rootstockModel::class, 'crop');
    }
}
