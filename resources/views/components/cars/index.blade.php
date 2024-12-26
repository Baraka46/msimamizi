<x-app-layout>
    <div class="container mx-auto my-5 p-4 bg-white shadow rounded-lg">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Car List</h1>
            <a href="{{ route('cars.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Create Car
            </a>
        </div>

        <!-- Table Section -->
        @if($cars->isEmpty())
            <p class="text-gray-500">No cars available.</p>
        @else
            <div class="overflow-x-auto">
                <!-- Table for Larger Screens -->
                <table class="hidden sm:table min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="text-left px-4 py-2"></th>
                            <th class="text-left px-4 py-2">Plate Number</th>
                            <th class="text-left px-4 py-2">Model</th>
                            <th class="text-left px-4 py-2">Route</th>
                            <th class="text-left px-4 py-2">Daily Hesabu Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $index => $car)
                            <tr 
                                class="border-b hover:bg-gray-50 cursor-pointer" 
                                onclick="openModal({{ json_encode($car) }})">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $car->plate_number }}</td>
                                <td class="px-4 py-2">{{ $car->model ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $car->route }}</td>
                                <td class="px-4 py-2">{{ $car->daily_hesabu_target }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cards for Small Screens -->
                <div class="sm:hidden">
                    @foreach($cars as $index => $car)
                        <div 
                            class="bg-gray-50 border border-gray-200 rounded-lg mb-4 p-4 shadow cursor-pointer"
                            onclick="openModal({{ json_encode($car) }})">
                            <h2 class="text-lg font-bold">Car {{ $index + 1 }}</h2>
                            <p><strong>Plate Number:</strong> {{ $car->plate_number }}</p>
                            <p><strong>Model:</strong> {{ $car->model ?? 'N/A' }}</p>
                            <p><strong>Route:</strong> {{ $car->route }}</p>
                            <p><strong>Daily Hesabu Target:</strong> {{ $car->daily_hesabu_target }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div id="carModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 id="modalTitle" class="text-lg font-bold mb-4">Car Details</h2>
            <div id="modalContent" class="mb-4">
                <p><strong>Plate Number:</strong> <span id="modalPlateNumber"></span></p>
                <p><strong>Model:</strong> <span id="modalModel"></span></p>
                <p><strong>Route:</strong> <span id="modalRoute"></span></p>
                <p><strong>Daily Hesabu Target:</strong> <span id="modalTarget"></span></p>
            </div>
            <div class="flex justify-end space-x-3">
                <a id="viewLink" href="#" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">View</a>
                <a id="editLink" href="#" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Edit</a>
                <form id="deleteForm" action="#" method="POST" class="inline-block">
    @csrf
    @method('DELETE')
    <button 
        type="submit" 
        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition" 
        onclick="return confirm('Are you sure?')">
        Delete
    </button>
</form>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function openModal(car) {
            document.getElementById('modalTitle').innerText = `Car Details - ${car.plate_number}`;
            document.getElementById('modalPlateNumber').innerText = car.plate_number;
            document.getElementById('modalModel').innerText = car.model ?? 'N/A';
            document.getElementById('modalRoute').innerText = car.route;
            document.getElementById('modalTarget').innerText = car.daily_hesabu_target;

            document.getElementById('viewLink').href = `{{ url('/cars') }}/${car.id}`;
    document.getElementById('editLink').href = `{{ url('/cars') }}/${car.id}/edit`;
    document.getElementById('deleteForm').action = `{{ url('/cars') }}/${car.id}`;
            document.getElementById('carModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('carModal').classList.add('hidden');
        }

        window.addEventListener('click', function (e) {
            if (e.target.id === 'carModal') {
                closeModal();
            }
        });
    </script>
</x-app-layout>

