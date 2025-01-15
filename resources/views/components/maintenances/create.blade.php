<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Add Maintenance Records</h1>

    <form action="{{ route('maintenances.storeMultiple') }}" method="POST" class="max-w-xl">
        @csrf
        <div class="mb-4">
            <label for="car_id" class="block text-gray-700 font-bold mb-2">Car:</label>
            <select name="car_id" id="car_id" class="w-full border rounded-md px-2 py-1">
                @foreach ($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->plate_number }} - {{ $car->model }}</option>
                @endforeach
            </select>
        </div>

        <div id="expenses-container">
            <div class="expense-row mb-4 border-b pb-4">
                <div class="mb-2">
                    <label class="block text-gray-700 font-bold mb-1">Expense Name:</label>
                    <input type="text" name="expenses[0][expense_name]" class="w-full border rounded-md px-2 py-1" required>
                </div>

                <div class="mb-2">
                    <label class="block text-gray-700 font-bold mb-1">Cost:</label>
                    <input type="number" name="expenses[0][cost]" step="0.01" min="0" class="w-full border rounded-md px-2 py-1" required>
                </div>

                <div class="mb-2">
                    <label class="block text-gray-700 font-bold mb-1">Description (Optional):</label>
                    <textarea name="expenses[0][description]" rows="2" class="w-full border rounded-md px-2 py-1"></textarea>
                </div>

                <div class="mb-2">
                    <label class="block text-gray-700 font-bold mb-1">Date:</label>
                    <input type="date" name="expenses[0][date]" value="{{ now()->toDateString() }}" class="w-full border rounded-md px-2 py-1" required>
                </div>

                <button type="button" class="remove-expense px-2 py-1 bg-red-500 text-white rounded-md">Remove</button>
            </div>
        </div>

        <button type="button" id="add-expense" class="px-4 py-2 bg-blue-500 text-white rounded-md mb-4">Add Another Expense</button>
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Save All</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let expenseIndex = 1;
            const expensesContainer = document.getElementById('expenses-container');
            const addExpenseButton = document.getElementById('add-expense');

            addExpenseButton.addEventListener('click', () => {
                const newExpense = `
                    <div class="expense-row mb-4 border-b pb-4">
                        <div class="mb-2">
                            <label class="block text-gray-700 font-bold mb-1">Expense Name:</label>
                            <input type="text" name="expenses[${expenseIndex}][expense_name]" class="w-full border rounded-md px-2 py-1" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 font-bold mb-1">Cost:</label>
                            <input type="number" name="expenses[${expenseIndex}][cost]" step="0.01" min="0" class="w-full border rounded-md px-2 py-1" required>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 font-bold mb-1">Description (Optional):</label>
                            <textarea name="expenses[${expenseIndex}][description]" rows="2" class="w-full border rounded-md px-2 py-1"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="block text-gray-700 font-bold mb-1">Date:</label>
                            <input type="date" name="expenses[${expenseIndex}][date]" value="{{ now()->toDateString() }}" class="w-full border rounded-md px-2 py-1" required>
                        </div>
                        <button type="button" class="remove-expense px-2 py-1 bg-red-500 text-white rounded-md">Remove</button>
                    </div>
                `;
                expensesContainer.insertAdjacentHTML('beforeend', newExpense);
                expenseIndex++;
            });

            expensesContainer.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-expense')) {
                    e.target.parentElement.remove();
                }
            });
        });
    </script>
</x-app-layout>
