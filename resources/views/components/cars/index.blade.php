<x-app-layout>
    <div class="container mx-auto my-5 p-4 bg-white shadow rounded-lg">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Car List</h1>
            @unless(Auth::user()->role === 'supervisor')
    <a href="{{ route('cars.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        Create Car
    </a>
@endunless

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
                            <th class="px-4 py-2">Action</th>  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $index => $car)
                           <tbody>
@foreach($cars as $index => $car)
  <tr class="border-b hover:bg-gray-50">
    <td class="px-4 py-2">{{ $index + 1 }}</td>
    <td class="px-4 py-2">{{ $car->plate_number }}</td>
    <td class="px-4 py-2">{{ $car->model ?? 'N/A' }}</td>
    <td class="px-4 py-2">{{ $car->route }}</td>
    <td class="px-4 py-2">{{ number_format($car->daily_hesabu_target) }}</td>
    <td class="px-4 py-2">
      <a href="{{ route('cars.show', $car->id) }}"
         class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
        View
      </a>
    </td>
  </tr>
@endforeach
</tbody>

                        @endforeach
                    </tbody>
                </table>

                <!-- Cards for Small Screens -->
               <div class="sm:hidden">
  @foreach($cars as $car)
    <div class="bg-gray-50 border border-gray-200 rounded-lg mb-4 p-4 shadow">
      <h2 class="text-lg font-bold">Plate: {{ $car->plate_number }}</h2>
      <p><strong>Model:</strong> {{ $car->model ?? 'N/A' }}</p>
      <p><strong>Route:</strong> {{ $car->route }}</p>
      <p><strong>Target:</strong> {{ number_format($car->daily_hesabu_target) }}</p>

      <div class="mt-4">
        <a href="{{ route('cars.show', $car->id) }}"
           class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          View
        </a>
      </div>
    </div>
  @endforeach
</div>

        @endif
    </div>


    <!-- Script -->
   
</x-app-layout>
