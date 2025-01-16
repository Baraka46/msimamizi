<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Services</h1>
        <a href="{{ route('services.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Add Service</a>

        <div class="mt-6 bg-white rounded-lg shadow-md">
            @forelse ($services->groupBy('car_id') as $carId => $carServices)
                <!-- Car Header -->
                <div class="bg-gray-100 px-4 py-2 text-lg font-semibold">
                    Car: {{ $carServices->first()->car->plate_number }}
                </div>
                
                <!-- Services for this car -->
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Service Type</th>
                            <th class="px-4 py-2">Cost</th>
                            <th class="px-4 py-2">Date Performed</th>
                            <th class="px-4 py-2">Next Due Date</th>
                            <th class="px-4 py-2">Days Left</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carServices as $service)
                            <tr>
                                <td class="px-4 py-2">{{ ucfirst($service->service_type) }} service</td>
                                <td class="px-4 py-2">{{ number_format($service->cost, 2) }}</td>
                                <td class="px-4 py-2">{{ $service->date_performed->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">{{ $service->next_due_date->format('Y-m-d') }}</td>
                                <td class="px-4 py-2">
    @php
        $daysLeft = $service->next_due_date->startOfDay()->diffInDays(now()->startOfDay(), false);
    @endphp
    @if ($daysLeft < 0)
        <span class="text-black font-se"> {{ abs((int)$daysLeft) }} days</span>
    @else
        <span class="text-green-500">{{ (int)$daysLeft }} days left</span>
    @endif
</td>

<td class="px-4 py-2">
    <!-- Edit Button -->
    <a href="{{ route('services.edit', $service->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md">Edit</a>
    
    <!-- Delete Form -->
    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md">Delete</button>
    </form>

    <!-- Perform Button -->
    <a href="{{ route('service_details.create', ['service_id' => $service->id]) }}" 
       class="bg-blue-500 text-white px-2 py-1 rounded-md">
        Perform
    </a>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @empty
                <!-- No Services -->
                <div class="px-4 py-2 text-center">
                    No services found.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
