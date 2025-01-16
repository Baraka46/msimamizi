<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6">Add New Service Detail</h1>

        <!-- Display Selected Service Details -->
        @if ($selectedService)
            <div class="mb-6 p-4 bg-gray-100 border border-gray-300 rounded-md">
                <p class="text-lg font-medium text-gray-700">
                    <strong>Car Plate Number:</strong> {{ $selectedService->car->plate_number ?? 'N/A' }}
                </p>
                <p class="text-lg font-medium text-gray-700">
                    <strong>Service Type:</strong> {{ ucfirst($selectedService->service_type) }}
                </p>
            </div>
        @endif

        <form action="{{ route('service_details.store') }}" method="POST">
            @csrf

            <!-- Service Selection -->
           

            <!-- Item Name -->
            <div class="mb-4">
                <label for="item_name" class="block text-lg font-medium text-gray-700">Item Name</label>
                <input type="text" name="item_name" id="item_name" class="mt-2 p-3 block w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-2 p-3 block w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Cost -->
            <div class="mb-4">
                <label for="cost" class="block text-lg font-medium text-gray-700">Cost</label>
                <input type="number" name="cost" id="cost" class="mt-2 p-3 block w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" step="0.01" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-md hover:bg-indigo-700 transition">Save</button>
        </form>
    </div>
</x-app-layout>
