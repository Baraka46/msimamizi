<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Add New Expense for {{ $group->name }}</h1>

        <form action="{{ route('expenses.store', $group) }}" method="POST">
            @csrf

            <!-- Car Group ID (Hidden Input) -->
            <input type="hidden" name="car_group_id" value="{{ $group->id }}">

            <!-- Expense Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Expense Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Expense Amount -->
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" step="0.01" required>
            </div>

            <!-- Expense Description -->
          

            <!-- Start Date -->
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Collection Interval -->
            <div class="mb-4">
                <label for="collection_interval" class="block text-sm font-medium text-gray-700">Collection Interval (Days)</label>
                <input type="number" name="collection_interval" id="collection_interval" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" min="1" required>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Add Expense</button>
                <a href="{{ route('expenses.index', $group) }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
