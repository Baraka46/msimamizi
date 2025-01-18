<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    // Table name (if different from default 'maintenances')
    protected $table = 'maintenance';

    // Mass-assignable attributes
    protected $fillable = [
        'car_id',
        'expense_name',
        'cost',
        'outstanding_balance',
        'description',
        'date',
    ];

    /**
     * Relationship: A maintenance belongs to a car.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Relationship: A maintenance has many payments.
     */
    public function payments()
    {
        return $this->hasMany(MaintenancePayment::class);
    }

    /**
     * Check if the maintenance is fully paid.
     *
     * @return bool
     */
    public function isFullyPaid()
    {
        return $this->outstanding_balance <= 0;
    }

    /**
     * Add a payment to this maintenance.
     *
     * @param float $amount
     * @return void
     * @throws \Exception
     */
    public function addPayment(float $amount)
    {
        if ($this->isFullyPaid()) {
            throw new \Exception("This maintenance is already fully paid.");
        }

        if ($amount > $this->outstanding_balance) {
            throw new \Exception("Payment exceeds outstanding balance.");
        }

        // Create the payment record
        $this->payments()->create([
            'amount' => $amount,
            'payment_date' => now(),
        ]);

        // Update the outstanding balance
        $this->outstanding_balance -= $amount;
        $this->save();
    }

    
}
