<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExpense extends Model
{
    protected $fillable = ['group_id', 'name', 'amount', 'description'];

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class, 'group_id');
    }
}
