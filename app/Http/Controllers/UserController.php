<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the list of supervisors.
     */
    public function index()
    {
        // Ensure that only the owner can access the list of supervisors
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }

        $ownerCompanyId = auth()->user()->company_id;

        // Get all active supervisors
        $supervisors = User::where('role', 'supervisor')
                           ->where('status', 'active')
                           ->get();

        // Get all inactive supervisors
        $disabledSupervisors = User::where('company_id', $ownerCompanyId)
                                   ->where('role', 'supervisor')
                                   ->where('status', 'inactive')
                                   ->get();

        // Pass both variables to the view
        return view('components.user.index', compact('supervisors', 'disabledSupervisors'));
    }

    /**
     * Show the form for creating a new supervisor.
     */
    public function create()
    {
        // Ensure that only the owner can create a new supervisor
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('home')->with('error', 'You are not authorized to perform this action.');
        }

        return view('components.user.create');
    }

    /**
     * Disable a supervisor.
     */
    public function disableSupervisor($id)
    {
        // Find the supervisor by ID
        $supervisor = User::findOrFail($id);

        // Ensure the user is a supervisor
        if ($supervisor->role !== 'supervisor') {
            return redirect()->route('supervisors.index')->with('error', 'This user is not a supervisor.');
        }

        // Mark the supervisor as inactive
        $supervisor->status = 'inactive';
        $supervisor->save();

        // Unassign the supervisor from all associated cars
        Car::where('assigned_supervisor_id', $supervisor->id)->update(['assigned_supervisor_id' => null]);

        return redirect()->route('supervisors.index')->with('success', 'Supervisor has been disabled.');
    }
    public function show($id)
    {
        // Find supervisor by ID
        $supervisor = User::findOrFail($id);
    
        // Ensure the user is a supervisor
        if ($supervisor->role !== 'supervisor') {
            return redirect()->route('supervisors.index')->with('error', 'Invalid supervisor.');
        }
    
        // Get cars assigned to the supervisor
        $assignedCars = Car::where('assigned_supervisor_id', $supervisor->id)->get();
    
        // Get available cars (not assigned to any supervisor)
        $availableCars = Car::whereNull('assigned_supervisor_id')->get();
    
        return view('components.user.details', compact('supervisor', 'assignedCars', 'availableCars'));
    }
    
    public function assignCars(Request $request, $id)
    {
        // Find supervisor by ID
        $supervisor = User::findOrFail($id);
    
        // Ensure the user is a supervisor
        if ($supervisor->role !== 'supervisor') {
            return redirect()->route('supervisors.show', $id)->with('error', 'Invalid supervisor.');
        }
    
        $request->validate([
            'car_ids' => 'required|array',
            'car_ids.*' => 'exists:cars,id',
        ]);
    
        // Assign selected cars to the supervisor
        Car::whereIn('id', $request->car_ids)->update(['assigned_supervisor_id' => $supervisor->id]);
    
        return redirect()->route('supervisors.show', $id)->with('success', 'Cars assigned successfully.');
    }
    public function unassignCar(Request $request, $supervisorId, $carId)
    {
        // Find supervisor by ID
        $supervisor = User::findOrFail($supervisorId);
    
        // Ensure the user is a supervisor
        if ($supervisor->role !== 'supervisor') {
            return redirect()->route('supervisors.show', $supervisorId)->with('error', 'Invalid supervisor.');
        }
    
        // Validate that the car exists and is currently assigned to the supervisor
        $car = Car::where('id', $carId)
            ->where('assigned_supervisor_id', $supervisor->id)
            ->firstOrFail();
    
        // Unassign the car from the supervisor
        $car->update(['assigned_supervisor_id' => null]);
    
        return redirect()->route('supervisors.show', $supervisorId)->with('success', 'Car unassigned successfully.');
    }
    

    
    /**
     * Enable a supervisor.
     */
    public function enableSupervisor($id)
    {
        // Find the supervisor by ID
        $supervisor = User::findOrFail($id);

        // Ensure the user is currently inactive
        if ($supervisor->status === 'inactive' && $supervisor->role === 'supervisor') {
            // Mark the supervisor as active
            $supervisor->status = 'active';
            $supervisor->save();

            return redirect()->route('supervisors.index')->with('success', 'Supervisor enabled successfully.');
        }

        // If the user is already active, return an error
        return redirect()->route('supervisors.index')->with('error', 'This supervisor is already active.');
    }
    

    /**
     * Store a newly created supervisor in storage.
     */
    public function store(Request $request)
    {
        // Ensure that only the owner can create a supervisor
        if (Auth::user()->role !== 'owner') {
            return redirect()->route('home')->with('error', 'You are not authorized to perform this action.');
        }

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
        'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $owner = Auth::user();
        // Create the supervisor user
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->address = $request->input('address');
        $user->password = Hash::make($request->input('password'));
        $user->role = 'supervisor'; // Assign supervisor role
        $user->company_id = $owner->company_id;
        $user->save();

        return redirect()->route('supervisors.index')->with('success', 'Supervisor created successfully.');
    }
}
