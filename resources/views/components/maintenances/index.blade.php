<x-app-layout>
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Maintenance Records</h1>
    <a href="{{ route('maintenances.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">Add Maintenance</a>

    @forelse ($cars as $car)
        <div class="mt-6 bg-white shadow-md rounded-lg p-4 border border-gray-300">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">
                <span class="text-blue-500">{{ $car->plate_number }}</span> - Route: <span class="text-gray-600">{{ $car->route }}</span>
            </h2>
            
            @if ($car->maintenances->isEmpty())
                <p class="text-pink-500 italic font-semibold">No maintenance records for this car.</p>
            @else
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="border px-4 py-2 text-gray-700">Expense Name</th>
                                <th class="border px-4 py-2 text-gray-700">Cost</th>
                                <th class="border px-4 py-2 text-gray-700">Description</th>
                                <th class="border px-4 py-2 text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($car->maintenances as $maintenance)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2 text-black">{{ $maintenance->expense_name }}</td>
                                    <td class="border px-4 py-2 text-black">{{ number_format($maintenance->cost, 2) }}</td>
                                    <td class="border px-4 py-2 text-black">{{ $maintenance->description ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2 text-black">{{ $maintenance->date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @empty
        <p class="text-gray-500 italic mt-4">No cars are assigned to you.</p>
    @endforelse
</x-app-layout>
