<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenancePayment;

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
                ->get()
                ;
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
            'expenses.*.amount_paid' => 'nullable|numeric|min:0', // Change this field name to match 'amount_paid'
            'expenses.*.description' => 'nullable|string',
            'expenses.*.date' => 'required|date',
            'expenses.*.payment_status' => 'required|in:paid,installment', // Add validation for payment status
        ]);
    
        foreach ($validated['expenses'] as $expense) {
            // Calculate outstanding balance
            $outstandingBalance = $expense['cost'];
    
            // If it's an installment, reduce the outstanding balance based on the amount paid
            if ($expense['payment_status'] === 'paid') {
                // Payment in full logic
                $outstandingBalance = 0; // Fully paid, no balance
                $initialPayment = $expense['cost']; // Full payment
            } elseif ($expense['payment_status'] === 'installment' && isset($expense['amount_paid'])) {
                // Installment logic
                $outstandingBalance -= $expense['amount_paid']; // Subtract amount paid from outstanding balance
            }
            
    
            // Create the maintenance entry
            $maintenance = Maintenance::create([
                'car_id' => $validated['car_id'],
                'expense_name' => $expense['expense_name'],
                'cost' => $expense['cost'],
                'outstanding_balance' => $outstandingBalance,
                'description' => $expense['description'] ?? null,
                'date' => $expense['date'],
                'payment_status' => $expense['payment_status'],
            ]);
    
            // If it's an installment, also store the payment in the payments table
            if ($expense['payment_status'] === 'installment' && isset($expense['amount_paid'])) {
                $maintenance->payments()->create([
                    'amount' => $expense['amount_paid'],
                    'payment_date' => now(), // Set the current date for payment
                ]);
            }
        }
    
        return redirect()->route('maintenances.index')->with('success', 'Maintenance recorded successfully!');
    }
    
    


    
    public function addPayment(Request $request, Maintenance $maintenance)
{
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1|max:' . $maintenance->outstanding_balance,
        'payment_date' => 'required|date',
    ]);

    // Record the payment in the maintenance_payments table
    MaintenancePayment::create([
        'maintenance_id' => $maintenance->id,
        'amount' => $validated['amount'],
        'payment_date' => $validated['payment_date'],
    ]);

    // Deduct the payment from the outstanding balance
    $maintenance->outstanding_balance -= $validated['amount'];
    if ($maintenance->outstanding_balance <= 0) {
        $maintenance->outstanding_balance = 0; // Ensure it doesn't go negative
    }
    $maintenance->save();

    return redirect()->route('maintenances.index')->with('success', 'Payment added successfully!');
}

    

    /**
     * View maintenance payments.
     */
    public function viewPayments(Maintenance $maintenance)
    {
        $payments = $maintenance->payments;

        return view('components.maintenances.payment', compact('maintenance', 'payments'));
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
