<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Maintenance;
use App\Models\DailyHesabu;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the logged-in user
        $role = $user->role;    // Assume the 'role' field determines the user's role

        $assignedCarsCount = 0;
        $assignedRoutes = [];
        $totalMaintenanceExpenses = 0;
        $totalHesabuCollected = 0;

        if ($role === 'supervisor') {
           
            $assignedCars = Car::where('assigned_supervisor_id', $user->id)->get();

            
            $assignedCarsCount = $assignedCars->count(); 

            $assignedRoutes = $assignedCars->pluck('route')->unique(); 

          
            $totalMaintenanceExpenses = Maintenance::whereIn('car_id', $assignedCars->pluck('id'))->sum('cost'); 

           
            $totalHesabuCollected = DailyHesabu::whereIn('car_id', $assignedCars->pluck('id'))
                ->sum('amount'); // Assuming 'amount' is the field in Hesabu model that stores the daily collection
        }

        return view('dashboard', compact(
            'user',
            'role',
            'assignedCarsCount',
            'assignedRoutes',
            'totalMaintenanceExpenses',
            'totalHesabuCollected'
        ));
    }
}
