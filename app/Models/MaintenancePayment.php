<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenancePayment extends Model
{
    use HasFactory;

    // Table name (if different from default 'maintenance_payments')
    protected $table = 'maintenance_payments';

    // Mass-assignable attributes
    protected $fillable = [
        'maintenance_id',
        'amount',
        'payment_date',
    ];

    /**
     * Relationship: A payment belongs to a maintenance.
     */
    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }
}
