<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InHouseMaintenance extends Model
{
    use HasFactory;
    protected $table = 'inhouse_maintenance';

    protected $fillable = ['car_id', 'item_name', 'cost','outstanding_balance'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function payments(){
        return $this->hasMany(InHouseMaintenancePayment::class);
    }
}
