<x-app-layout>
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Add New Service</h1>

    <form action="{{ route('services.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="car_id" class="block font-semibold mb-2">Car</label>
            <select name="car_id" id="car_id" class="w-full border-gray-300 rounded-md p-2">
                @foreach($assignedCars as $car)
                    <option value="{{ $car->id }}">{{ $car->plate_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="service_type" class="block font-semibold mb-2">Service Type</label>
            <select name="service_type" id="service_type" class="w-full border-gray-300 rounded-md p-2">
                <option value="oil">Oil</option>
                <option value="tires">Tires</option>
                <option value="engine">Engine</option>
                <option value="balljoint">Balljoint</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="cost" class="block font-semibold mb-2">Cost</label>
            <input type="number" name="cost" id="cost" class="w-full border-gray-300 rounded-md p-2" step="0.01" required>
        </div>

        <div class="mb-4">
            <label for="date_performed" class="block font-semibold mb-2">Date Performed</label>
            <input type="date" name="date_performed" id="date_performed" class="w-full border-gray-300 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label for="next_due_date" class="block font-semibold mb-2">Next Due Date (optional)</label>
            <input type="date" name="next_due_date" id="next_due_date" class="w-full border-gray-300 rounded-md p-2">
        </div>

        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Service</button>
        </div>
    </form>
</div>
</x-app-layout>
