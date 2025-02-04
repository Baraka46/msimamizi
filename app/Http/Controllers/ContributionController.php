<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Models\GroupExpense;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GroupExpense $expense)
    {
        $contributions = $expense->contributions()->latest()->get();
        return view('components.cars.contribution-index', compact('expense', 'contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(GroupExpense $expense)
    {
        return view('components.cars.contribution-create', compact('expense'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GroupExpense $expense)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'intended_collection_date' => 'required|date',
        ]);
    
        // Add group_expense_id manually and set actual_collection_date as today
        $validatedData['group_expense_id'] = $expense->id;
        $validatedData['actual_collection_date'] = now(); 
    
        $expense->contributions()->create($validatedData);
    
        return redirect()->route('expenses.contributions.index', $expense)
                         ->with('success', 'Contribution added successfully.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(GroupExpense $expense, Contribution $contribution)
    {
        return view('components.cars.contribution-show', compact('expense', 'contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GroupExpense $expense, Contribution $contribution)
    {
        return view('components.cars.contribution-edit', compact('expense', 'contribution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GroupExpense $expense, Contribution $contribution)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
            'contribution_date' => 'required|date',
        ]);

        $contribution->update($validatedData);

        return redirect()->route('expenses.contributions.index', $expense)
                         ->with('success', 'Contribution updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupExpense $expense, Contribution $contribution)
    {
        $contribution->delete();

        return redirect()->route('expenses.contributions.index', $expense)
                         ->with('success', 'Contribution deleted successfully.');
    }
}
