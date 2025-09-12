<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class croptypeModel extends Model
{
    use HasFactory;
    protected $table = 'crop_type';

    protected $fillable = [
        'e_type',
        'h_type',
    ];
    public function crops()
    {
        return $this->hasMany(cropModel::class, 'type');
    }
}
