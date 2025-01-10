<x-app-layout>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-blue-500 mb-4">Supervisor: {{ $supervisor->name }}</h1>
        <p class="text-gray-700"><strong>Email:</strong> {{ $supervisor->email }}</p>
        <p class="text-gray-700 mb-6"><strong>Status:</strong> 
            <span class="{{ $supervisor->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($supervisor->status) }}
            </span>
        </p>

        <h2 class="text-xl font-semibold text-pink-600 mb-4">Assigned Cars</h2>
@if ($assignedCars->isEmpty())
    <p class="text-gray-600">No cars assigned yet.</p>
@else
    <ul class="divide-y divide-gray-200 mb-6">
        @foreach ($assignedCars as $car)
            <li class="flex justify-between items-center py-2">
                <div class="flex items-center space-x-4">
                    <span class="font-semibold text-gray-700">{{ $car->plate_number }}</span>
                    <span class="text-gray-500">{{ $car->model }}</span>
                </div>
                <!-- Unassign Button -->
                <form action="{{ route('supervisors.unassign-car', [$supervisor->id, $car->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="px-3 py-1 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Unassign
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endif


       <form action="{{ route('supervisors.assign-cars', $supervisor->id) }}" method="POST" class="mb-6">
    @csrf
    @method('PATCH') <!-- Add this line to specify PATCH -->
    <h2 class="text-xl font-semibold text-pink-600 mb-4">Assign Cars</h2>
    <div class="mb-4">
        <label for="car_ids" class="block text-gray-700 mb-2">Select Cars:</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($availableCars as $car)
            <div class="flex items-center space-x-2 border border-gray-300 p-3 rounded-md shadow-sm">
                <input 
                    type="checkbox" 
                    name="car_ids[]" 
                    value="{{ $car->id }}" 
                    id="car-{{ $car->id }}" 
                    class="form-checkbox h-5 w-5 text-blue-500 focus:ring-blue-500 focus:border-blue-500">
                <label for="car-{{ $car->id }}" class="text-gray-700">
                    <span class="font-semibold">{{ $car->plate_number }}</span> - {{ $car->route }}
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <button type="submit" 
        class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">
        Assign Cars
    </button>
</form>

</form>


        <a href="{{ route('supervisors.index') }}" 
           class="inline-block px-4 py-2 bg-pink-600 text-white rounded-md shadow-md hover:bg-pink-700">
            Back to Supervisors
        </a>
    </div>
</x-app-layout>
