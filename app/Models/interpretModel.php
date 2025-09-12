<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class interpretModel extends Model
{
     use HasFactory;
     protected $table = 'interpret';

    protected $fillable = [
        'parameter',
        'min',
        'max',
        'interpretation',
        'color',
    ];
}
