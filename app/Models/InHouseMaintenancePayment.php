<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InHouseMaintenancePayment extends Model
{
    use HasFactory;
    protected $table ='inhouse_maintenance_payments';

    protected $fillable = [ 'amount','payment_date'];

    public function inHouseMaintanance()
    {
        return $this->belongsTo(InHouseMaintenance::class);
    }
}
