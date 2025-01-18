<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Car;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role === 'supervisor') {
            // Get the IDs of cars assigned to the supervisor
            $assignedCarIds = Car::where('assigned_supervisor_id', auth()->id())->pluck('id');
            
            // Get services for the assigned cars
            $services = Service::whereIn('car_id', $assignedCarIds)->get();
        } elseif (auth()->user()->role === 'owner') {
            // Owners can see all services
            $services = Service::all();
        } else {
            // Empty collection for other roles or unauthorized access
            $services = collect();
        }  // Or filter by car, supervisor, etc.
        return view('components.services.index', compact('services'));
    }

    public function create()
    {
        
        
        if (auth()->user()->role === 'supervisor') {
            $assignedCars = Car::where('assigned_supervisor_id', auth()->id())->get();
        } elseif (auth()->user()->role === 'owner') {
            $assignedCars = Car::all(); // Fetch all cars for the owner
        } else {
            $assignedCars = collect(); // Empty collection if the user has no specific role
        }
        return view('components.services.create', compact('assignedCars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'service_type' => 'required|in:oil,tires,engine,balljoint',
            'date_performed' => 'required|date',
            'next_due_date' => 'nullable|date',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $assignedCars = Car::where('assigned_supervisor_id', auth()->id())->get(); // Only assigned cars
        return view('services.edit', compact('service', 'assignedCars'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'service_type' => 'required|in:oil,tires,engine,balljoint',
            'date_performed' => 'required|date',
            'next_due_date' => 'nullable|date',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
