<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Edit Expense</h1>

        <form action="{{ route('cars.group.expenses.update', $expense) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Expense Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Expense Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ $expense->name }}" required>
            </div>

            <!-- Expense Amount -->
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ $expense->amount }}" step="0.01" required>
            </div>

            <!-- Expense Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3">{{ $expense->description }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Update Expense</button>
                <a href="{{ route('cars.group.expenses.index', $expense->group_id) }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>