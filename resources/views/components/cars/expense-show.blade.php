<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Expense Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p><strong>Name:</strong> {{ $expense->name }}</p>
            <p><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</p>
            <p><strong>Description:</strong> {{ $expense->description ?? 'N/A' }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('cars.group.expenses.index', $expense->group_id) }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Back to Expenses</a>
        </div>
    </div>
</x-app-layout>