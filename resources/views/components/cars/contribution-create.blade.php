<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Add Contribution</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('expenses.contributions.store', $expense->id) }}" method="POST">
                @csrf
                
                {{-- Amount Field --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Amount</label>
                    <input type="number" name="amount" step="0.01" class="w-full p-2 border rounded-lg" required>
                </div>

                {{-- Intended Collection Date Field --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Intended Collection Date</label>
                    <input type="date" name="intended_collection_date" class="w-full p-2 border rounded-lg" required>
                </div>

                {{-- Submit Button --}}
                <div class="flex space-x-4 mt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Submit Contribution
                    </button>
                    <a href="{{ route('expenses.show', $expense->id) }}" 
                       class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
