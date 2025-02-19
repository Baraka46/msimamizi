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
        // Get all payments
        $payments = InhouseMaintenancePayment::latest()->paginate(10);
        return view('inhouse_payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show a form to make a payment
        $maintenances = InhouseMaintenance::where('remaining_balance', '>', 0)->get();
        return view('inhouse_payments.create', compact('maintenances'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amountToPay = $validated['amount'];

        // Get total outstanding balance
        $totalOutstanding = InhouseMaintenance::where('remaining_balance', '>', 0)->sum('remaining_balance');

        if ($totalOutstanding <= 0) {
            return back()->with('error', 'No outstanding balance to pay.');
        }

        // Get all unpaid in-house maintenance records
        $unpaidMaintenances = InhouseMaintenance::where('remaining_balance', '>', 0)->get();

        foreach ($unpaidMaintenances as $maintenance) {
            $percentage = $maintenance->remaining_balance / $totalOutstanding;
            $amountAllocated = round($amountToPay * $percentage, 2);

            if ($amountAllocated > $maintenance->remaining_balance) {
                $amountAllocated = $maintenance->remaining_balance;
            }

            $maintenance->remaining_balance -= $amountAllocated;
            $maintenance->save();

            // Save the payment record
            InhouseMaintenancePayment::create([
                'maintenance_id' => $maintenance->id,
                'amount' => $amountAllocated,
                'payment_date' => now(),
            ]);
        }

        return back()->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show payment details
        $payment = InhouseMaintenancePayment::findOrFail($id);
        return view('inhouse_payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Edit a payment
        $payment = InhouseMaintenancePayment::findOrFail($id);
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

        $payment = InhouseMaintenancePayment::findOrFail($id);
        $payment->amount = $validated['amount'];
        $payment->save();

        return redirect()->route('inhouse_payments.index')->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = InhouseMaintenancePayment::findOrFail($id);
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
        $totalOutstanding = InhouseMaintenance::where('remaining_balance', '>', 0)->sum('remaining_balance');
    
        if ($totalOutstanding <= 0) {
            return back()->with('error', 'No outstanding balance to pay.');
        }
    
        // Get all unpaid in-house maintenance records
        $unpaidMaintenances = InhouseMaintenance::where('remaining_balance', '>', 0)->get();
    
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
        $totalOwed = InhouseMaintenance::sum('remaining_balance');
        InhouseTotalOwed::where('id', 1)->update(['total_owed' => $totalOwed]);
    
        return back()->with('success', 'Payment distributed successfully!');
    }
    

}
