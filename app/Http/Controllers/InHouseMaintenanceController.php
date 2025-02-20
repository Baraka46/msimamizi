<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\InHouseMaintenance;

use App\Models\InHouseMaintenancePayment;

class InHouseMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all payments
        $payments = InHouseMaintenancePayment::latest()->paginate(10);
        return view('inhouse_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show a form to make a payment
        $maintenances = InHouseMaintenance::where('outstanding_balance', '>', 0)->get();
        return view('components.inhouse_payments.create', compact('maintenances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'item_name' => 'required|array',
            'item_name.*' => 'required|string|max:255',
            'cost' => 'required|array',
            'cost.*' => 'required|numeric|min:0',
        ]);
    
        // Loop through and save multiple items
        foreach ($validated['item_name'] as $index => $name) {
            InHouseMaintenance::create([
                'car_id' => $validated['car_id'],
                'item_name' => $name,
                'cost' => $validated['cost'][$index],
            ]);
        }
    
        return back()->with('success', 'Items saved successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show payment details
        $payment = InHouseMaintenancePayment::findOrFail($id);
        return view('inhouse_payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Edit a payment
        $payment = InHouseMaintenancePayment::findOrFail($id);
        return view('inhouse_payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $payment = InHouseMaintenancePayment::findOrFail($id);
        $payment->amount = $validated['amount'];
        $payment->save();

        return redirect()->route('inhouse_payments.index')->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = InHouseMaintenancePayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('inhouse_payments.index')->with('success', 'Payment deleted successfully!');
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
