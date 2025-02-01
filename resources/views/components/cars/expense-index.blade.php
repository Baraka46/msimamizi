<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Expenses for {{ $group->name }}</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Expense Button -->
        <div class="mb-6">
            <a href="{{ route('expenses.create', $group) }}" class="px-6 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Add New Expense
            </a>
        </div>

        <!-- Expenses Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">collection time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">start date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
    @forelse ($expenses as $expense)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-semi-bold">
                <a href="{{ route('expenses.show', $expense->id) }}" class="text-indigo-600 hover:underline">
                    {{ $expense->name }}
                </a>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($expense->amount) }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->collection_interval }} days</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $expense->start_date }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No expenses found.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>
</x-app-layout>