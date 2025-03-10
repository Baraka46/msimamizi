<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Add New Car</h1>
        <form action="{{ route('cars.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="plate_number" class="block text-sm font-medium text-gray-700">Plate Number</label>
                <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="plate_number" name="plate_number" required>
            </div>
            <div class="mb-4">
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="model" name="model">
            </div>
            <div class="mb-4">
                <label for="route" class="block text-sm font-medium text-gray-700">Route</label>
                <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="route" name="route" required>
            </div>
            <div class="mb-4">
                <label for="daily_hesabu_target" class="block text-sm font-medium text-gray-700">Daily Hesabu Target</label>
                <input type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="daily_hesabu_target" name="daily_hesabu_target" required>
            </div>
          
            <div class="flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Add Car</button>
                <a href="{{ route('cars.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Back to Car List</a>
            </div>
        </form>
    </div>
</x-app-layout>
