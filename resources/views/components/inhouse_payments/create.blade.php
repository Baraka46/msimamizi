<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Add New Records</h2>

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
        <form action="{{ route('in-house-maintenance.store') }}" method="POST">
            @csrf

            {{-- Select Category --}}
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Select Category</label>
                <select name="category_id" id="category_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Records Section --}}
            <div id="records-entries">
                <div class="record-entry mb-6 p-4 border rounded-lg shadow-md" data-index="0">
                    <h5 class="text-lg font-semibold mb-4">Record Entry</h5>

                    {{-- Name --}}
                    <div class="mb-4">
                        <label for="records[0][name]" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="records[0][name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    {{-- Value --}}
                    <div class="mb-4">
                        <label for="records[0][value]" class="block text-sm font-medium text-gray-700">Value</label>
                        <input type="number" name="records[0][value]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="records[0][description]" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea name="records[0][description]" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2"></textarea>
                    </div>
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

    {{-- JavaScript --}}
    <script>
        document.getElementById('add-entry').addEventListener('click', function () {
            const index = document.querySelectorAll('.record-entry').length;
            const entryHtml = `
                <div class="record-entry mb-6 p-4 border rounded-lg shadow-md" data-index="${index}">
                    <h5 class="text-lg font-semibold mb-4">Record Entry</h5>
                    <div class="mb-4">
                        <label for="records[${index}][name]" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="records[${index}][name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="records[${index}][value]" class="block text-sm font-medium text-gray-700">Value</label>
                        <input type="number" name="records[${index}][value]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="records[${index}][description]" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea name="records[${index}][description]" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2"></textarea>
                    </div>
                    <button type="button" class="remove-entry text-red-500 hover:text-red-700 mt-4">Remove Entry</button>
                </div>`;
            document.getElementById('records-entries').insertAdjacentHTML('beforeend', entryHtml);
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-entry')) {
                e.target.closest('.record-entry').remove();
            }
        });
    </script>
</x-app-layout>
