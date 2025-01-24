<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Create Car Group</h1>
        <form action="{{ route('GroupStore.store') }}" method="POST">
            @csrf

            <!-- Group Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Group Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Group Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3"></textarea>
            </div>

            <!-- Car Selection with Tom Select -->
            <div class="mb-4">
                <label for="car_ids" class="block text-sm font-medium text-gray-700">Select Cars</label>
                <select name="car_ids[]" id="car_ids" class="mt-1 block w-full" multiple placeholder="Select cars...">
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->plate_number }} ({{ $car->license_plate }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Create Group</button>
                <a href="{{ route('GroupIndex.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">Back to Group List</a>
            </div>
        </form>
    </div>

    <!-- Include Tom Select CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- Initialize Tom Select -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new TomSelect('#car_ids', {
                plugins: ['remove_button'],
                placeholder: 'Select cars...',
                maxItems: null, // Allow unlimited selections
                searchField: 'text', // Enable search functionality
                render: {
                    option: function(data, escape) {
                        return `<div>${escape(data.text)}</div>`;
                    },
                    item: function(data, escape) {
                        return `<div>${escape(data.text)}</div>`;
                    }
                }
            });
        });
    </script>
</x-app-layout>