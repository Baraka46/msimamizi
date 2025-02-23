<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Add New Maintenance Records</h2>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('in-house-maintenances.storeMultiple') }}" method="POST">
            @csrf

            {{-- Select Car --}}
            <div class="mb-4">
                <label for="car_id" class="block text-sm font-medium text-gray-700">Select Car</label>
                <select name="car_id" id="car_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select --</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->plate_number }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Maintenance Records Section --}}
            <div id="maintenance-entries">
                <div class="maintenance-entry mb-6 p-4 border rounded-lg shadow-md" data-index="0">
                    <h5 class="text-lg font-semibold mb-4">Maintenance Record</h5>

                    {{-- Item Name --}}
                    <div class="mb-4">
                        <label for="maintenances[0][item_name]" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" name="maintenances[0][item_name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    {{-- Cost --}}
                    <div class="mb-4">
                        <label for="maintenances[0][cost]" class="block text-sm font-medium text-gray-700">Cost (TSh)</label>
                        <input type="number" name="maintenances[0][cost]" step="0.01" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                   
                  

                    {{-- Date --}}
                    <div class="mb-4">
                        <label for="maintenances[0][date]" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="maintenances[0][date]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    {{-- Remove Button --}}
                    <button type="button" class="remove-entry text-red-500 hover:text-red-700 mt-4">Remove Entry</button>
                </div>
            </div>

            {{-- Add More Button --}}
            <div class="mb-6">
                <button type="button" id="add-entry" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none">Add Another Record</button>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none">Save Records</button>
            </div>
        </form>
    </div>

    {{-- JavaScript for Dynamic Entries --}}
    <script>
        document.getElementById('add-entry').addEventListener('click', function () {
            const index = document.querySelectorAll('.maintenance-entry').length;
            const entryHtml = `
                <div class="maintenance-entry mb-6 p-4 border rounded-lg shadow-md" data-index="${index}">
                    <h5 class="text-lg font-semibold mb-4">Maintenance Record</h5>
                    <div class="mb-4">
                        <label for="maintenances[${index}][item_name]" class="block text-sm font-medium text-gray-700">Item Name</label>
                        <input type="text" name="maintenances[${index}][item_name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="maintenances[${index}][cost]" class="block text-sm font-medium text-gray-700">Cost (TSh)</label>
                        <input type="number" name="maintenances[${index}][cost]" step="0.01" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="maintenances[${index}][description]" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea name="maintenances[${index}][description]" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="maintenances[${index}][date]" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="maintenances[${index}][date]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <button type="button" class="remove-entry text-red-500 hover:text-red-700 mt-4">Remove Entry</button>
                </div>`;
            document.getElementById('maintenance-entries').insertAdjacentHTML('beforeend', entryHtml);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-entry')) {
                e.target.closest('.maintenance-entry').remove();
            }
        });
    </script>
</x-app-layout>
