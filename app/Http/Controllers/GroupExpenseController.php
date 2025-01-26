<?php

namespace App\Http\Controllers;

use App\Models\GroupExpense;
use Illuminate\Http\Request;
use App\Models\CarGroup;

class GroupExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CarGroup $group)
    {
        $expenses = $group->groupExpenses()->latest()->get();

        return view('components.cars.expense-index', compact('group', 'expenses'));
    }

    /**
     * Show the form for creating a new expense for a specific group.
     */
    public function create(CarGroup $group)
    {
        return view(' components.cars.expense-create', compact('group'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request, CarGroup $group)
    {
        $validatedData = $request->validate([
            'car_group_id'=> 'required|exists:car_groups,id',
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'start_date'=> 'required|date',
            'collection_interval' => 'required|integer|min:1',

        ]);

        $group->groupExpenses()->create($validatedData);

        return redirect()->route('expenses.index', $group)
                         ->with('success', 'Expense added successfully.');
    }

    /**
     * Display the specified expense.
     */
    public function show(GroupExpense $expense)
    {
        return view('components.cars.expense-show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(GroupExpense $expense)
    {
        return view('components.cars.expense-edit', compact('expense'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, GroupExpense $expense)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $expense->update($validatedData);

        return redirect()->route('cars.group.expenses.index', $expense->group_id)
                         ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(GroupExpense $expense)
    {
        $groupId = $expense->group_id;
        $expense->delete();

        return redirect()->route('cars.group.expenses.index', $groupId)
                         ->with('success', 'Expense deleted successfully.');
    }
}
