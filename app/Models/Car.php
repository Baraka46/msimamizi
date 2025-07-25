<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plate_number',
        'model',
        'route',
        'daily_hesabu_target',
        'assigned_supervisor_id',
    ];

    /**
     * Get the company that owns the car.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the supervisor assigned to the car.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'assigned_supervisor_id');
    }
    
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }



    public function inhouse_maintenance()
    {
        return $this->hasMany(InHouseMaintenance::class);
    }
    /**
     * Scope to restrict car access to the owner of the company.
     */
    public function scopeForOwner($query, $user)
    {
        // Ensure that the car belongs to the user's company
        return $query->where('company_id', $user->company_id);
    }
    public function dailyHesabus()
    {
        return $this->hasMany(DailyHesabu::class, 'car_id', 'id');
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function CarGroup()
    {
        return $this->hasOne(CarGroup::class);
    }




    
}


