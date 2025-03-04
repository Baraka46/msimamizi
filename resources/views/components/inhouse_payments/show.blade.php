<x-app-layout>
<div class="max-w-6xl mx-auto p-6 bg-gray-100 min-h-screen">
    <!-- Car Details -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6 bg-white shadow-md p-4 rounded-lg">
        🚗 Car: <span class="text-blue-600">{{ $car->plate_number }}</span>
    </h2>

    <!-- Maintenance Table -->
    <div class="overflow-hidden bg-white shadow-lg rounded-lg">
        <table class="min-w-full border-collapse w-full">
            <thead>
                <tr class="bg-blue-600 text-white text-left text-sm uppercase">
                    <th class="px-6 py-3">Item Name</th>
                    <th class="px-6 py-3">Cost</th>
                    <th class="px-6 py-3">Outstanding Balance</th>
                    <th class="px-6 py-3">Date</th>
                    
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($car->inhouse_maintenance as $maintenance)
                <tr class="border-t hover:bg-gray-100 transition">
                    <td class="px-6 py-4">{{ $maintenance->item_name }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ number_format($maintenance->cost, 2) }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($maintenance->outstanding_balance == 0)
                            <span class="text-green-500 font-medium">✔ Fully Paid</span>
                        @else
                            <span class="text-red-500 font-medium">{{ number_format($maintenance->outstanding_balance, 2) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($maintenance->date)->format('M d, Y') }}</td>
                   
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- No Maintenance Message -->
    @if ($car->maintenances->isEmpty())
        <div class="mt-6 text-center text-gray-600">
            No maintenance records found for this car.
        </div>
    @endif
</div>
</x-app-layout>
