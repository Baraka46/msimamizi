<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Add Maintenance Record</h2>

        {{-- Display validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
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
            <div class="mb-3">
                <label for="car_id" class="form-label">Select Car</label>
                <select name="car_id" id="car_id" class="form-select" required>
                    <option value="">-- Select a Car --</option>
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->plate_number }} ({{ $car->route }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Maintenance Details Section --}}
            <div id="maintenance-entries">
                <div class="maintenance-entry mb-4">
                    <h5>Maintenance Entry</h5>

                    {{-- Expense Name --}}
                    <div class="mb-3">
                        <label for="expenses[0][expense_name]" class="form-label">Expense Name</label>
                        <input type="text" name="expenses[0][expense_name]" class="form-control" placeholder="e.g., Tire Change" required>
                    </div>

                    {{-- Cost --}}
                    <div class="mb-3">
                        <label for="expenses[0][cost]" class="form-label">Cost (in USD)</label>
                        <input type="number" step="0.01" name="expenses[0][cost]" class="form-control" placeholder="e.g., 200" required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="expenses[0][description]" class="form-label">Description (Optional)</label>
                        <textarea name="expenses[0][description]" class="form-control" rows="2" placeholder="e.g., Changed front and rear tires"></textarea>
                    </div>

                    {{-- Date --}}
                    <div class="mb-3">
                        <label for="expenses[0][date]" class="form-label">Date</label>
                        <input type="date" name="expenses[0][date]" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>

                    {{-- Payment Status --}}
                    <div class="mb-3">
                        <label for="expenses[0][payment_status]" class="form-label">Payment Status</label>
                        <select name="expenses[0][payment_status]" class="form-select payment-status" data-index="0" required>
                            <option value="paid">Paid in Full</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>

                    {{-- Amount Paid (only if installment is selected) --}}
                    <div class="mb-3 amount-paid" data-index="0" style="display: none;">
                        <label for="expenses[0][amount_paid]" class="form-label">Amount Paid</label>
                        <input type="number" step="0.01" name="expenses[0][amount_paid]" class="form-control" placeholder="e.g., 100">
                    </div>
                </div>
            </div>

            {{-- Add More Button --}}
            <div class="mb-3">
                <button type="button" id="add-entry" class="btn btn-secondary">Add Another Maintenance Entry</button>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="btn btn-primary">Save Maintenance Records</button>
            </div>
        </form>
    </div>

    {{-- JavaScript Section --}}
    <script>
        document.getElementById('add-entry').addEventListener('click', function () {
            const index = document.querySelectorAll('.maintenance-entry').length;
            const entryHtml = `
                <div class="maintenance-entry mb-4">
                    <h5>Maintenance Entry</h5>
                    <div class="mb-3">
                        <label for="expenses[${index}][expense_name]" class="form-label">Expense Name</label>
                        <input type="text" name="expenses[${index}][expense_name]" class="form-control" placeholder="e.g., Tire Change" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenses[${index}][cost]" class="form-label">Cost (in USD)</label>
                        <input type="number" step="0.01" name="expenses[${index}][cost]" class="form-control" placeholder="e.g., 200" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenses[${index}][description]" class="form-label">Description (Optional)</label>
                        <textarea name="expenses[${index}][description]" class="form-control" rows="2" placeholder="e.g., Changed front and rear tires"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="expenses[${index}][date]" class="form-label">Date</label>
                        <input type="date" name="expenses[${index}][date]" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="expenses[${index}][payment_status]" class="form-label">Payment Status</label>
                        <select name="expenses[${index}][payment_status]" class="form-select payment-status" data-index="${index}" required>
                            <option value="paid">Paid in Full</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>
                    <div class="mb-3 amount-paid" data-index="${index}" style="display: none;">
                        <label for="expenses[${index}][amount_paid]" class="form-label">Amount Paid</label>
                        <input type="number" step="0.01" name="expenses[${index}][amount_paid]" class="form-control" placeholder="e.g., 100">
                    </div>
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

        attachPaymentStatusLogic();
    </script>
</x-app-layout>
