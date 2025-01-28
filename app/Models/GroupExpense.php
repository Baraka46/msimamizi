<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupExpense extends Model
{
    use HasFactory;
    protected $fillable = ['car_group_id', 'name', 'amount', 'start_date', 'collection_interval' ];

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class, 'car_group_id');
    }
}
