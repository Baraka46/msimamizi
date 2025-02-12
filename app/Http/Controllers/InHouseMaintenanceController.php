<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InHouseMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function makePayment(Request $request)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $amountToPay = $validated['amount'];

    // Get all unpaid in-house maintenance balances (oldest first)
    $unpaidMaintenances = InhouseMaintenance::where('remaining_balance', '>', 0)
        ->orderBy('date', 'asc')
        ->get();

    foreach ($unpaidMaintenances as $maintenance) {
        if ($amountToPay <= 0) {
            break; // Stop if payment is fully used
        }

        if ($amountToPay >= $maintenance->remaining_balance) {
            // Fully pay off this record
            $amountToPay -= $maintenance->remaining_balance;
            $maintenance->remaining_balance = 0;
        } else {
            // Partial payment, update balance
            $maintenance->remaining_balance -= $amountToPay;
            $amountToPay = 0;
        }

        $maintenance->save();
    }

    // Update the total owed table
    $totalOwed = InhouseMaintenance::sum('remaining_balance');
    InhouseTotalOwed::where('id', 1)->update(['total_owed' => $totalOwed]);

    return back()->with('success', 'Payment processed successfully!');
}

}
