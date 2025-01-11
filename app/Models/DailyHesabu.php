<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyHesabu extends Model
{
    //
    use HasFactory;
    protected $table = 'daily_hesabu';


    protected $fillable = [
        'car_id',
        'supervisor_id',
        'amount',
        'collection_time',
        'description',
    ];
}
