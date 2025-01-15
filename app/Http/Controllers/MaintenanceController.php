<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = Maintenance::with('car')->latest()->get();
        $cars = Car::where('assigned_supervisor_id', Auth::id())
                ->with('maintenances')
                ->get();
        return view('components.maintenances.index', compact('maintenances','cars'));
    }

    public function create()
    {
        $cars = Car::where('assigned_supervisor_id', Auth::id())->get();

        // If no cars are assigned, redirect with a message
        if ($cars->isEmpty()) {
            return redirect()->route('dashboard')->with('info', 'No cars are assigned to you.');
        }
    
        return view('components.maintenances.create', compact('cars'));
    }

    public function storeMultiple(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'expenses' => 'required|array',
            'expenses.*.expense_name' => 'required|string|max:255',
            'expenses.*.cost' => 'required|numeric|min:0',
            'expenses.*.description' => 'nullable|string',
            'expenses.*.date' => 'required|date',
        ]);
    
        foreach ($validated['expenses'] as $expense) {
            Maintenance::create([
                'car_id' => $validated['car_id'],
                'expense_name' => $expense['expense_name'],
                'cost' => $expense['cost'],
                'description' => $expense['description'] ?? null,
                'date' => $expense['date'],
            ]);
        }
    
        return redirect()->route('maintenances.index')->with('success', 'Maintenance recorded successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        //
    }
}
