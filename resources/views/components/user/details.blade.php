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
            <ul class="list-disc pl-5 text-gray-700 mb-6">
                @foreach ($assignedCars as $car)
                    <li>{{ $car->plate_number }} - {{ $car->model }}</li>
                @endforeach
            </ul>
        @endif

        <h2 class="text-xl font-semibold text-pink-600 mb-4">Assign Cars</h2>
        <form action="{{ route('supervisors.assign-cars', $supervisor->id) }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="car_ids" class="block text-gray-700 mb-2">Select Cars:</label>
                <select name="car_ids[]" id="car_ids" multiple required 
                    class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($availableCars as $car)
                        <option value="{{ $car->id }}">{{ $car->plate_number }} - {{ $car->model }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" 
                class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-md hover:bg-blue-600">
                Assign Cars
            </button>
        </form>

        <a href="{{ route('supervisors.index') }}" 
           class="inline-block px-4 py-2 bg-pink-600 text-white rounded-md shadow-md hover:bg-pink-700">
            Back to Supervisors
        </a>
    </div>
</x-app-layout>
