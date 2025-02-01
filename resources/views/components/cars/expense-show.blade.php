<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Expense Details: {{ $expense->name }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p><strong>Name:</strong> {{ $expense->name }}</p>
            <p><strong>Amount:</strong> {{ number_format($expense->amount, ) }}</p>
            <p><strong>Collection Interval:</strong> {{ $expense->collection_interval ?? 'N/A' }} days</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($expense->start_date)->toFormattedDateString() ?? 'N/A' }}</p>


            <p><strong>Next Collection Date:</strong> {{ $nextCollectionDate }}</p>
        </div>

        <a href="{{ route('expenses.index', $expense->car_group_id) }}" 
           class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Back to Expenses
        </a>

    </div>
</x-app-layout>
