<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Add Maintenance Record</h1>

    <form action="{{ route('maintenances.store') }}" method="POST" class="max-w-xl">
        @csrf
        <div class="mb-4">
            <label for="car_id" class="block text-gray-700 font-bold mb-2">Car:</label>
            <select name="car_id" id="car_id" class="w-full border rounded-md px-2 py-1">
                @foreach ($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->plate_number }} - {{ $car->model }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="expense_name" class="block text-gray-700 font-bold mb-2">Expense Name:</label>
            <input type="text" name="expense_name" id="expense_name" class="w-full border rounded-md px-2 py-1" required>
        </div>

        <div class="mb-4">
            <label for="cost" class="block text-gray-700 font-bold mb-2">Cost:</label>
            <input type="number" name="cost" id="cost" step="0.01" min="0" class="w-full border rounded-md px-2 py-1" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description (Optional):</label>
            <textarea name="description" id="description" rows="4" class="w-full border rounded-md px-2 py-1"></textarea>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-gray-700 font-bold mb-2">Date:</label>
            <input type="date" name="date" id="date" value="{{ now()->toDateString() }}" class="w-full border rounded-md px-2 py-1" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Save</button>
    </form>
</x-app-layout>
