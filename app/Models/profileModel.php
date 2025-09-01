<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profileModel extends Model
{
    use HasFactory;
    protected $table = 'profile';

    protected $fillable = [
        'id',
        'user_id',
        'fullname',
        'username',
        'gender',
        'id_type',
        'id_no',
        'contact',
        'whatsapp',
        'email',
        'qualification',
        'address',
        'postoffice',
        'district',
        'state',
        'pincode',
        'referred_by',
        'crop_grown',
        'land_area_cultivated',
        'land_area_total',
        'farming_since',
        'technology_intervention',
        'capital_investment',
        'future_plans',
        'info_on_all_crops',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
