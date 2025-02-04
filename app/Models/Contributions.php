<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contributions extends Model
{
    //
    use HasFactory;
    protected $fillable = ['group_expense_id', 
    'amount', 
    'intended_collection_date',
     'actual_collection_date'];
     public function groupExpenses(){
        return $this->belongsTo(GroupExpenses::class);
     }
}

