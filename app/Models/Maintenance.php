<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;
    protected $table = 'maintenance';

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
