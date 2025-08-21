<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentsModel extends Model
{
     use HasFactory;
     protected $table = 'payments';

    protected $fillable = [
        'date',
        'amount',
        'sample_id',
        'transaction_id',
        'confirm_payment',
        'mode',
        'status',
    ];
}
