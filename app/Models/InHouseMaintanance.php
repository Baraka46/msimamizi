<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InHouseMaintanance extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'item_name', 'cost'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function payments(){
        return $this->hasMany(InHouseMaintanancePayment::class);
    }
}
