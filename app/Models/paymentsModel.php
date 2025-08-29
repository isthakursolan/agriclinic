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
        'no_of_samples',
        'details',
        'confirm_payment',
        'mode',
        'status',
    ];
      public function sample()
    {
        return $this->belongsTo(sampleModel::class, 'sample_id');
    }
}
