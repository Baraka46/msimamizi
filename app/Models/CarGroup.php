<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarGroup extends Model
{
    //
    use HasFactory;
    protected $fillable = ['name', 'car_id', 'description','company_id'];
    
    public function car()
    {
        return $this->$this->HasMany(Car::class);
    }
}
