<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Expense Details: {{ $expense->name }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p><strong>Name:</strong> {{ $expense->name }}</p>
            <p><strong>Amount:</strong> {{ number_format($expense->amount, 2) }}</p>
            <p><strong>Collection Interval:</strong> {{ $expense->collection_interval ?? 'N/A' }} days</p>
            <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($expense->start_date)->toFormattedDateString() ?? 'N/A' }}</p>
            <p><strong>Next Collection Date:</strong> {{ $nextCollectionDate }}</p>
        </div>

        {{-- Buttons Section --}}
        <div class="flex justify-start space-x-4 mt-4">
            <a href="{{ route('expenses.contributions.create', $expense->id) }}" 
               class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Add Contribution
            </a>
            <a href="{{ route('expenses.index', $expense->car_group_id) }}" 
               class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Back to Expenses
            </a>
        </div>

        {{-- Recent Contributions Section --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Recent Contributions</h2>
            @if($recentContributions->isEmpty())
                <p class="text-gray-600">No contributions have been made yet.</p>
            @else
                <div class="bg-white shadow-md rounded-lg p-4">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-4 border">Amount</th>
                                <th class="py-2 px-4 border">Intended Collection Date</th>
                                <th class="py-2 px-4 border">Actual Collection Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentContributions as $contribution)
                                <tr class="border-t">
                                    <td class="py-2 px-4 border">{{ number_format($contribution->amount, 2) }}</td>
                                    <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($contribution->intended_collection_date)->toFormattedDateString() }}</td>
                                    <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($contribution->actual_collection_date)->toFormattedDateString() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
