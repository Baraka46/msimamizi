<x-app-layout>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-blue-500 mb-4">Car Details</h1>

        <p class="mb-2"><span class="font-semibold text-gray-700">Plate Number:</span> {{ $car->plate_number }}</p>
        <p class="mb-2"><span class="font-semibold text-gray-700">Model:</span> {{ $car->model }}</p>
        <p class="mb-2"><span class="font-semibold text-gray-700">Route:</span> {{ $car->route }}</p>
        <p class="mb-2"><span class="font-semibold text-gray-700">Daily Hesabu Target:</span> {{ $car->daily_hesabu_target }}</p>
        <p class="mb-4">
            <span class="font-semibold text-gray-700">Supervisor:</span> 
            @if ($car->assigned_supervisor_id)
                <span class="text-blue-500">{{ $car->supervisor->name ?? 'Unknown' }}</span>
            @else
                <span class="text-pink-600 font-bold">No Supervisor Assigned</span>
            @endif
        </p>

        @if (!$car->assigned_supervisor_id)
            <a href="{{ route('cars.assign-supervisor', ['id' => $car->id]) }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Assign Supervisor
            </a>
        @endif
    </div>
</x-app-layout>
