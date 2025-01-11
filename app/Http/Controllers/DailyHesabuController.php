<?php

namespace App\Http\Controllers;

use App\Models\DailyHesabu;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class DailyHesabuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Get the current date
    $today = Carbon::today();

    // Get the logged-in supervisor's ID
    $supervisorId = auth()->user()->id;

    // Cars assigned to the supervisor that have not been filled today
    $unfilledCars = Car::where('assigned_supervisor_id', $supervisorId)
        ->whereDoesntHave('dailyHesabus', function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        })
        ->get();

    // Cars assigned to the supervisor that have been filled today
    $filledCars = Car::where('assigned_supervisor_id', $supervisorId)
        ->whereHas('dailyHesabus', function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        })
        ->with(['dailyHesabus' => function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        }])
        ->get();

    // Pass the data to the view
    return view('components.hesabu.addHesabu', [
        'unfilledCars' => $unfilledCars,
        'filledCars' => $filledCars,
    ]);
}


public function store(Request $request)
{
    $request->validate([
        'car_id' => 'required|exists:cars,id',
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable|string|max:255',
    ]);

    $car = Car::findOrFail($request->car_id);

    // Ensure the supervisor is authorized
    if (auth()->user()->id !== $car->assigned_supervisor_id) {
        return redirect()->back()->with('error', 'You are not authorized to add hesabu for this car.');
    }

    // Get the target amount
    $targetAmount = $car->daily_hesabu_target;

    // Add hesabu entry
    DailyHesabu::create([
        'car_id' => $request->car_id,
        'supervisor_id' => auth()->user()->id,
        'amount' => $request->amount,
        'collection_time' => now(), // Automatically capture the current time
        'description' => $request->amount < $targetAmount ? $request->description : null,
    ]);

    return redirect()->back()->with('success', 'Daily hesabu added successfully.');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    
    /**
     * Display the specified resource.
     */
    public function show(DailyHesabu $dailyHesabu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyHesabu $dailyHesabu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyHesabu $dailyHesabu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyHesabu $dailyHesabu)
    {
        //
    }
}
