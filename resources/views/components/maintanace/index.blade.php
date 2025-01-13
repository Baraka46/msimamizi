
<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Maintenance Records</h1>
    <a href="{{ route('maintenances.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Add Maintenance</a>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Car</th>
                    <th class="border px-4 py-2">Expense Name</th>
                    <th class="border px-4 py-2">Cost</th>
                    <th class="border px-4 py-2">Description</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintenances as $maintenance)
                    <tr>
                        <td class="border px-4 py-2">{{ $maintenance->car->plate_number ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $maintenance->expense_name }}</td>
                        <td class="border px-4 py-2">{{ number_format($maintenance->cost, 2) }}</td>
                        <td class="border px-4 py-2">{{ $maintenance->description ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $maintenance->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
