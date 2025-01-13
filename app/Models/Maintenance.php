<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'expense_name',
        'cost',
        'description',
        'date',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
