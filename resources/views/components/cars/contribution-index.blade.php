<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Contributions for {{ $expense->name }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if ($contributions->isEmpty())
                <p class="text-gray-500">No contributions made yet.</p>
            @else
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">Amount</th>
                            <th class="border p-2">Intended Date</th>
                            <th class="border p-2">Actual Collection Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contributions as $contribution)
                            <tr class="border">
                                <td class="border p-2">{{ number_format($contribution->amount, 2) }}</td>
                                <td class="border p-2">{{ \Carbon\Carbon::parse($contribution->intended_collection_date)->toFormattedDateString() }}</td>
                                <td class="border p-2">{{ \Carbon\Carbon::parse($contribution->actual_collection_date)->toFormattedDateString() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('expenses.show', $expense->id) }}" 
               class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Back to Expense
            </a>
        </div>
    </div>
</x-app-layout>
