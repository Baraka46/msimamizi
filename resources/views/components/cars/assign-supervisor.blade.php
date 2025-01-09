<x-app-layout>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-blue-500 mb-6">
            Assign Supervisor to Car: <span class="text-gray-700">{{ $car->plate_number }}</span>
        </h1>

        <form action="{{ route('cars.update-supervisor', ['id' => $car->id]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="supervisor_id" class="block text-gray-700 font-semibold mb-2">
                    Select Supervisor:
                </label>
                <select name="supervisor_id" id="supervisor_id" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>-- Select Supervisor --</option>
                    @foreach ($supervisors as $supervisor)
                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" 
                    class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg">
                Assign
            </button>
        </form>
    </div>
</x-app-layout>
