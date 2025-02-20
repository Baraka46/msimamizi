<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InHouseMaintenancePayment extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    public function inHouseMaintanance()
    {
        return $this->belongsTo(InHouseMaintenance::class);
    }
}
