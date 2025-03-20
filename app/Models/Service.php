<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $fillable = ['car_id',	'service_type',	'date_performed',	'next_due_date' ];

    protected $casts = [
        'date_performed' => 'datetime',
        'next_due_date' => 'datetime',
    ];
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
