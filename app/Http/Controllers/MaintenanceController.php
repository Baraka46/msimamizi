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
    // 1) Determine mode up front
    $mode = $request->input('entry_mode', 'form'); 
    // ‘form’ = the per‑entry form; ‘bulk’ = the bulk‑paste textarea

    if ($mode === 'bulk') {
        //
        // ── BULK MODE ──────────────────────────────────────────────────────
        //
        // Validate only the fields we need for bulk:
        $data = $request->validate([
            'car_id'               => 'required|exists:cars,id',
            'bulk_data'            => 'required|string',      // pasted lines
            'bulk_date'            => 'required|date',        // one date for all
            'bulk_payment_status'  => 'required|in:paid,installment',
            'bulk_amount_paid'     => 'nullable|numeric|min:0', // only if installment
        ]);

        // Split the textarea into lines
        $lines = preg_split('/\r?\n/', trim($data['bulk_data']));

        foreach ($lines as $line) {
            // Split each line by comma or tab into 3 parts
            $parts = array_map('trim', preg_split('/[\t,]/', $line));
            [$name, $cost, $desc] = array_pad($parts, 3, null);

            // Build a single associative array matching your normal form’s $expense structure
            $expense = [
                'expense_name'   => $name,
                'cost'           => (float)$cost,
                'description'    => $desc,
                'date'           => $data['bulk_date'],
                'payment_status' => $data['bulk_payment_status'],
                'amount_paid'    => $data['bulk_payment_status'] === 'installment'
                                     ? ($data['bulk_amount_paid'] ?? 0)
                                     : (float)$cost,
            ];

            // Delegate to shared creation logic
            $this->createMaintenance($data['car_id'], $expense);
        }

    } else {
        //
        // ── FORM MODE ──────────────────────────────────────────────────────
        //
        // Validate the full array of expenses entries
        $validated = $request->validate([
            'car_id'                  => 'required|exists:cars,id',
            'expenses'                => 'required|array',
            'expenses.*.expense_name' => 'required|string|max:255',
            'expenses.*.cost'         => 'required|numeric|min:0',
            'expenses.*.description'  => 'nullable|string',
            'expenses.*.date'         => 'required|date',
            'expenses.*.payment_status'=> 'required|in:paid,installment',
            'expenses.*.amount_paid'  => 'nullable|numeric|min:0',
        ]);

        // Loop over each sub‑array and create maintenance
        foreach ($validated['expenses'] as $expense) {
            $this->createMaintenance($validated['car_id'], $expense);
        }
    }

    // Redirect back to the index
    return redirect()
        ->route('maintenances.index')
        ->with('success', 'Maintenance recorded successfully!');
}

/**
 * Shared logic: create one Maintenance and its first Payment (if any)
 *
 * @param  int   $carId
 * @param  array $expense  keys: expense_name, cost, description, date, payment_status, amount_paid
 */
protected function createMaintenance(int $carId, array $expense)
{
    // Calculate how much remains outstanding
    $cost = $expense['cost'];
    $paid = $expense['payment_status'] === 'paid'
            ? $cost
            : ($expense['amount_paid'] ?? 0);

    $outstanding = max($cost - $paid, 0);

    // 1) Create the maintenance record
    $maintenance = Maintenance::create([
        'car_id'               => $carId,
        'expense_name'         => $expense['expense_name'],
        'cost'                 => $cost,
        'outstanding_balance'  => $outstanding,
        'description'          => $expense['description'] ?? null,
        'date'                 => $expense['date'],
        'payment_status'       => $expense['payment_status'],
    ]);

    // 2) If anything was paid upfront, record it in the payments table
    if ($paid > 0) {
        $maintenance->payments()->create([
            'amount'       => $paid,
            'payment_date' => now(),
        ]);
    }
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
