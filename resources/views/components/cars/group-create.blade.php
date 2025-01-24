<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Add New Car</h1>
        <form action="{{ route('GroupStore.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Group Name</label>
                <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="plate_number" name="plate_number" required>
            </div>
            <div class="mb-4">
                <label for="car_id" class="block text-sm font-medium text-gray-700">Select Car</label>
                <select name="car_id" id="car_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select a Car --</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->plate_number }} ({{ $car->route }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                <input type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" id="route" name="route" required>
            </div>
            
          
            <div class="flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Add Group</button>
                <a href="{{ route('CarGroup.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Back to Car List</a>
            </div>
        </form>
    </div>
</x-app-layout>
