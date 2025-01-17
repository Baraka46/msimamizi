<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Only allow owners or admins to access cars
    

    /**
     * Show the list of cars for the logged-in user
     */
    public function index()
{
    $user = auth()->user();

    // Admin and Owner can see their cars
    if ($user->isOwner() || $user->isAdmin()) {
        $cars = Car::when($user->isOwner(), function ($query) use ($user) {
            // Restrict access for owners to only their own company
            $query->forOwner($user);
        })->get();

        return view('components.cars.index', compact('cars'));
    }

    // Supervisors can see cars they are supervising
    if ($user->isSupervisor()) {
        $cars = Car::where('assigned_supervisor_id', $user->id)->get();

        return view('components.cars.index', compact('cars'));
    }

    // If the user doesn't match any role, redirect to dashboard
    return redirect()->route('dashboard')->with('error', 'Unauthorized');
}



    /**
     * Show the form for creating a new car
     */
    public function create()
    {
        return view('components.cars.create');
    }

    /**
     * Store a newly created car
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:cars,plate_number',
            'model' => 'nullable|string',
            'route' => 'required|string',
            'daily_hesabu_target' => 'required|integer',
            'assigned_supervisor_id' => 'nullable|exists:users,id',
        ]);

        $car = Car::create([
            'company_id' => auth()->user()->company_id, // Only allow owner to create cars for their company
            'plate_number' => $request->plate_number,
            'model' => $request->model,
            'route' => $request->route,
            'daily_hesabu_target' => $request->daily_hesabu_target,
            'assigned_supervisor_id' => $request->assigned_supervisor_id,
        ]);

        return redirect()->route('cars.index')->with('success', 'Car created successfully.');
    }

    /**
     * Show the details of a specific car
     */
    public function show($id)
{
    $car = Car::findOrFail($id); // Fetch the car by ID
    return view('components.cars.show', compact('car'));
}
public function assignSupervisorForm($id)
{
    $car = Car::findOrFail($id);
    $supervisors = User::where('role', 'supervisor')->get(); // Fetch available supervisors

    return view('components.cars.assign-supervisor', compact('car', 'supervisors'));
}

public function assignSupervisor(Request $request, $id)
{
    $car = Car::findOrFail($id);

    $request->validate([
        'supervisor_id' => 'required|exists:users,id',
    ]);

    $car->update(['assigned_supervisor_id' => $request->supervisor_id]);

    return redirect()->route('cars.show', $id)->with('success', 'Supervisor assigned successfully.');
}

    
    /**
     * Show the form for editing a car
     */
    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the details of a specific car
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'plate_number' => 'required|unique:cars,plate_number,' . $car->id,
            'model' => 'nullable|string',
            'route' => 'required|string',
            'daily_hesabu_target' => 'required|integer',
            'assigned_supervisor_id' => 'nullable|exists:users,id',
        ]);

        $car->update($request->all());

        return redirect()->route('cars.index')->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified car
     */
    public function destroy($id)
{
    $car = Car::findOrFail($id);
    // Check if the authenticated user is the owner
    if (auth()->user()->id !== $car->company_id) {
        return redirect()->route('cars.index')->with('error', 'Unauthorized action');
    }

    $car->delete();
    return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
}
}
