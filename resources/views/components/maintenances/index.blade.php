<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-6">
        <h1 class="text-2xl font-bold mb-6">Maintenances</h1>

        <!-- Button to create a new maintenance -->
        <div class="mb-4">
            <a href="{{ route('maintenances.create') }}" class="bg-blue-500 text-white px-2 py-2 rounded-lg hover:bg-blue-600">Add Maintenance</a>
        </div>

        @foreach ($cars as $car)
            <h2 class="text-xl font-semibold mb-4">Car: {{ $car->plate_number }}</h2>

            <div class="overflow-x-auto bg-white shadow-lg rounded-lg mb-6">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Expense Name</th>
                            <th class="px-4 py-2 text-left">Cost</th>
                            <th class="px-4 py-2 text-left">Outstanding Balance</th>
                            <th class="px-4 py-2 text-left">Date</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($car->maintenances as $maintenance)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $maintenance->expense_name }}</td>
                                <td class="px-4 py-2">{{ $maintenance->cost }}</td>
                                <td class="px-4 py-2">
                                    @if ($maintenance->outstanding_balance == 0)
                                        <span class="text-green-500">Fully Paid</span>
                                    @else
                                        <span class="text-red-500">{{ $maintenance->outstanding_balance }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $maintenance->date }}</td>
                                <td class="px-4 py-2">
                                    <!-- View Payments button -->
                                    <a href="{{ route('maintenances.viewPayments', $maintenance) }}" class="text-blue-500 hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</x-app-layout>
