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
            'expenses.*.amount_paid' => 'nullable|numeric|min:0', 
            'expenses.*.description' => 'nullable|string',
            'expenses.*.date' => 'required|date',
            'expenses.*.payment_status' => 'required|in:paid,installment', 
        ]);
    
        foreach ($validated['expenses'] as $expense) {
            
            $outstandingBalance = $expense['cost'];
            $initialPayment = 0;
    
            if ($expense['payment_status'] === 'paid') {
               
                $outstandingBalance = 0; // 
                $initialPayment = $expense['cost']; 
            } elseif ($expense['payment_status'] === 'installment' && isset($expense['amount_paid'])) {
                
                $outstandingBalance -= $expense['amount_paid']; 
                $initialPayment = $expense['amount_paid']; 
            }
    
            $maintenance = Maintenance::create([
                'car_id' => $validated['car_id'],
                'expense_name' => $expense['expense_name'],
                'cost' => $expense['cost'],
                'outstanding_balance' => $outstandingBalance,
                'description' => $expense['description'] ?? null,
                'date' => $expense['date'],
                'payment_status' => $expense['payment_status'],
            ]);
    
           
            if ($initialPayment > 0) {
                $maintenance->payments()->create([
                    'amount' => $initialPayment,
                    'payment_date' => now(), 
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

    MaintenancePayment::create([
        'maintenance_id' => $maintenance->id,
        'amount' => $validated['amount'],
        'payment_date' => $validated['payment_date'],
    ]);

    $maintenance->outstanding_balance -= $validated['amount'];
    if ($maintenance->outstanding_balance <= 0) {
        $maintenance->outstanding_balance = 0; 
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
