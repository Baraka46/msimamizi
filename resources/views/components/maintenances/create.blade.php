<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold mb-6">Add Maintenance Record</h2>

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

        {{-- Form to add maintenance --}}
        <form action="{{ route('maintenances.storeMultiple') }}" method="POST">
            @csrf

            {{-- Select car --}}
            <div class="mb-4">
                <label for="car_id" class="block text-sm font-medium text-gray-700">Select Car</label>
                <select name="car_id" id="car_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select a Car --</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->plate_number }} ({{ $car->route }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Maintenance Details Section --}}
            <div id="maintenance-entries">
                <div class="maintenance-entry mb-6 p-4 border rounded-lg shadow-md" data-index="0">
                    <h5 class="text-lg font-semibold mb-4">Maintenance Entry</h5>

                    {{-- Expense Name --}}
                    <div class="mb-4">
                        <label for="expenses[0][expense_name]" class="block text-sm font-medium text-gray-700">Expense Name</label>
                        <input type="text" name="expenses[0][expense_name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Tire Change" required>
                    </div>

                    {{-- Cost --}}
                    <div class="mb-4">
                        <label for="expenses[0][cost]" class="block text-sm font-medium text-gray-700">Cost Tzs</label>
                        <input type="number" step="0.01" name="expenses[0][cost]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 200" required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="expenses[0][description]" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea name="expenses[0][description]" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2" placeholder="e.g., Changed front and rear tires"></textarea>
                    </div>

                    {{-- Date --}}
                    <div class="mb-4">
                        <label for="expenses[0][date]" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="expenses[0][date]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ now()->toDateString() }}" required>
                    </div>

                    {{-- Payment Status --}}
                    <div class="mb-4">
                        <label for="expenses[0][payment_status]" class="block text-sm font-medium text-gray-700">Payment Status</label>
                        <select name="expenses[0][payment_status]" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 payment-status" data-index="0" required>
                            <option value="paid">Paid in Full</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>

                    {{-- Amount Paid (only if installment is selected) --}}
                    <div class="mb-4 amount-paid" data-index="0" style="display: none;">
                        <label for="expenses[0][amount_paid]" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                        <input type="number" step="0.01" name="expenses[0][amount_paid]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 100">
                    </div>
                </div>
            </div>

            {{-- Add More Button --}}
            <div class="mb-6">
                <button type="button" id="add-entry" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none">Add Another Maintenance Entry</button>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none">Save Maintenance Records</button>
            </div>
        </form>
    </div>

    {{-- JavaScript Section --}}
    <script>
        document.getElementById('add-entry').addEventListener('click', function () {
            const index = document.querySelectorAll('.maintenance-entry').length;
            const entryHtml = `
                <div class="maintenance-entry mb-6 p-4 border rounded-lg shadow-md" data-index="${index}">
                    <h5 class="text-lg font-semibold mb-4">Maintenance Entry</h5>
                    <div class="mb-4">
                        <label for="expenses[${index}][expense_name]" class="block text-sm font-medium text-gray-700">Expense Name</label>
                        <input type="text" name="expenses[${index}][expense_name]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Tire Change" required>
                    </div>
                    <div class="mb-4">
                        <label for="expenses[${index}][cost]" class="block text-sm font-medium text-gray-700">Cost </label>
                        <input type="number" step="0.01" name="expenses[${index}][cost]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., 200" required>
                    </div>
                    <div class="mb-4">
                        <label for="expenses[${index}][description]" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                        <textarea name="expenses[${index}][description]" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" rows="2" placeholder="e.g., Changed front and rear tires"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="expenses[${index}][date]" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="expenses[${index}][date]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="expenses[${index}][payment_status]" class="block text-sm font-medium text-gray-700">Payment Status</label>
                        <select name="expenses[${index}][payment_status]" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 payment-status" data-index="${index}" required>
                            <option value="paid">Paid in Full</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>
                    <div class="mb-4 amount-paid" data-index="${index}" style="display: none;">
                        <label for="expenses[${index}][amount_paid]" class="block text-sm font-medium text-gray-700">Amount Paid</label>
                        <input type="number" step="0.01" name="expenses[${index}][amount_paid]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 100">
                    </div>
                    <button type="button" class="remove-entry text-red-500 hover:text-red-700 mt-4">Remove Entry</button>
                </div>`;
            document.getElementById('maintenance-entries').insertAdjacentHTML('beforeend', entryHtml);
            attachPaymentStatusLogic();
        });

        function attachPaymentStatusLogic() {
            document.querySelectorAll('.payment-status').forEach(select => {
                select.addEventListener('change', function () {
                    const index = this.getAttribute('data-index');
                    const amountPaidDiv = document.querySelector(`.amount-paid[data-index="${index}"]`);
                    amountPaidDiv.style.display = (this.value === 'installment') ? 'block' : 'none';
                });
            });
        }

        // Function to remove a maintenance entry
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-entry')) {
                const entry = e.target.closest('.maintenance-entry');
                const index = entry.getAttribute('data-index');

                // Do not show the Remove button for the first entry
                if (index > 0) {
                    entry.remove();
                }
            }
        });

        attachPaymentStatusLogic();
    </script>
</x-app-layout>
