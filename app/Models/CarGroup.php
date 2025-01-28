<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarGroup extends Model
{
    //
    use HasFactory;
    protected $fillable = ['name', 'car_id', 'description','company_id'];
    
    public function cars()
    {
        return $this->HasMany(Car::class);
    }
    public function groupExpenses()
{
    return $this->hasMany(GroupExpense::class);
}

}
