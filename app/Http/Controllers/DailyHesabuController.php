<?php

namespace App\Http\Controllers;

use App\Models\DailyHesabu;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class DailyHesabuController extends Controller
{
   
    public function index()
{
  
    $today = Carbon::today();
    $supervisorId = auth()->user()->id;
    $weekly =Car::where('assigned_supervisor_id', $supervisorId)
        ->with('dailyHesabus')
        ->get();
    $unfilledCars = Car::where('assigned_supervisor_id', $supervisorId)
        ->whereDoesntHave('dailyHesabus', function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        })
        ->get();
    $filledCars = Car::where('assigned_supervisor_id', $supervisorId)
        ->whereHas('dailyHesabus', function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        })
        ->with(['dailyHesabus' => function ($query) use ($today) {
            $query->whereDate('collection_time', $today);
        }])
        ->get();
    return view('components.hesabu.addHesabu', [
        'unfilledCars' => $unfilledCars,
        'filledCars' => $filledCars,
        'weekly'=>$weekly,
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
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'description' => 'nullable|string|max:255',
    ]);

    $car = $dailyHesabu->car;
    $target = $car->daily_hesabu_target;

    if (auth()->id() !== $dailyHesabu->supervisor_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $dailyHesabu->update([
        'amount' => $request->amount,
        'description' => $request->amount < $target ? $request->description : null,
    ]);

    return response()->json(['success' => true]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyHesabu $dailyHesabu)
    {
        //
    }
}
