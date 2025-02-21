<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\InHouseMaintenance;
use App\Models\Car;
use App\Models\InHouseMaintenancePayment;
use Illuminate\Support\Facades\Auth;

class InHouseMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all in-house maintenance records for cars assigned to the logged-in supervisor
        $inhouseMaintenances = InHouseMaintenance::whereHas('car', function ($query) {
            $query->where('assigned_supervisor_id', Auth::id());
        })->with('car')->latest()->get();

        // Get the list of cars assigned to the supervisor
        $cars = Car::where('assigned_supervisor_id', Auth::id())->with('maintenances')->get();

        return view('components.inhouse_maintenances.index', compact('inhouseMaintenances', 'cars'));
    }

    /**
     * Show the form for creating a new maintenance record.
     */
   
    /**
     * Display a specific maintenance record.
     */
    public function show(string $id)
    {
        $maintenance = InHouseMaintenance::with('car')->findOrFail($id);
        return view('components.inhouse_maintenances.show', compact('maintenance'));
    }

    /**
     * Show the form for editing an existing maintenance record.
     */
    public function edit(string $id)
    {
        $maintenance = InHouseMaintenance::findOrFail($id);
        return view('components.inhouse_maintenances.edit', compact('maintenance'));
    }

    /**
     * Update a specific maintenance record.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $maintenance = InHouseMaintenance::findOrFail($id);
        $maintenance->update($validated);

        return redirect()->route('inhouse_maintenances.index')->with('success', 'Maintenance record updated successfully!');
    }

    /**
     * Delete a maintenance record.
     */
    public function destroy(string $id)
    {
        $maintenance = InHouseMaintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('inhouse_maintenances.index')->with('success', 'Maintenance record deleted successfully!');
    }
    public function makePayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
    
        $amountToPay = $validated['amount'];
    
        // Get total outstanding balance
        $totalOutstanding = InHouseMaintenance::where('remaining_balance', '>', 0)->sum('remaining_balance');
    
        if ($totalOutstanding <= 0) {
            return back()->with('error', 'No outstanding balance to pay.');
        }
    
        // Get all unpaid in-house maintenance records
        $unpaidMaintenances = InHouseMaintenance::where('remaining_balance', '>', 0)->get();
    
        foreach ($unpaidMaintenances as $maintenance) {
            // Calculate the percentage of debt this maintenance holds
            $percentage = $maintenance->remaining_balance / $totalOutstanding;
    
            // Allocate payment proportionally
            $amountAllocated = round($amountToPay * $percentage, 2);
    
            // Ensure we don't overpay
            if ($amountAllocated > $maintenance->remaining_balance) {
                $amountAllocated = $maintenance->remaining_balance;
            }
    
            $maintenance->remaining_balance -= $amountAllocated;
            $maintenance->save();
        }
    
        // Recalculate total owed
        $totalOwed = InHouseMaintenance::sum('remaining_balance');
        InhouseTotalOwed::where('id', 1)->update(['total_owed' => $totalOwed]);
    
        return back()->with('success', 'Payment distributed successfully!');
    }
    

}
