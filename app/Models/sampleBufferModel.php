<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sampleBufferModel extends Model
{
    use HasFactory;
    protected $table = 'sample_buffer';

    protected $fillable = [
        'sample_id',
        'sample_type',
        'accept_by',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'accept_by');
    }
}
