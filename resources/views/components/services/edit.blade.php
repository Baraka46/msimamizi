<x-app-layout>
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Edit Service</h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        {{-- Car selection --}}
        <div class="mb-4">
            <label for="car_id" class="block font-semibold mb-2">Car</label>
            <select name="car_id" id="car_id" class="w-full border-gray-300 rounded-md p-2">
                @foreach($assignedCars as $car)
                    <option value="{{ $car->id }}" {{ $car->id == $service->car_id ? 'selected' : '' }}>
                        {{ $car->plate_number }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Service type --}}
        <div class="mb-4">
            <label for="service_type" class="block font-semibold mb-2">Service Type</label>
            <select name="service_type" id="service_type" class="w-full border-gray-300 rounded-md p-2">
                @foreach(['oil', 'tires', 'engine', 'balljoint'] as $type)
                    <option value="{{ $type }}" {{ $service->service_type === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Date performed --}}
        <div class="mb-4">
            <label for="date_performed" class="block font-semibold mb-2">Date Performed</label>
            <input type="date" name="date_performed" id="date_performed"
                value="{{ old('date_performed', $service->date_performed->format('Y-m-d')) }}"
                class="w-full border-gray-300 rounded-md p-2" required>
        </div>

        {{-- Next due date --}}
        <div class="mb-4">
            <label for="next_due_date" class="block font-semibold mb-2">Next Due Date (optional)</label>
            <input type="date" name="next_due_date" id="next_due_date"
                value="{{ old('next_due_date', optional($service->next_due_date)->format('Y-m-d')) }}"
                class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Update Service</button>
        </div>
    </form>
</div>
</x-app-layout>
