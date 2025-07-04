<x-app-layout>
  <div class="bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-500">
    <!-- Title with Icon -->
    <div class="flex items-center mb-6">
      
      <h1 class="text-2xl font-bold text-blue-500">Car Details</h1>
    </div>

    <!-- Tabs -->
    <div x-data="{ tab: 'overview' }" class="mb-6">
      <nav class="flex space-x-4 border-b">
        <button
          @click="tab = 'overview'"
          :class="tab === 'overview' ? 'border-blue-500 text-blue-500' : 'text-gray-600 hover:text-blue-500'"
          class="pb-2 border-b-2 font-semibold"
        >Overview</button>

        <button
          @click="tab = 'daily'"
          :class="tab === 'daily' ? 'border-blue-500 text-blue-500' : 'text-gray-600 hover:text-blue-500'"
          class="pb-2 border-b-2 font-semibold"
        >Daily Income</button>

        <button
          @click="tab = 'maintenance'"
          :class="tab === 'maintenance' ? 'border-blue-500 text-blue-500' : 'text-gray-600 hover:text-blue-500'"
          class="pb-2 border-b-2 font-semibold"
        >Maintenance</button>

        <button
          @click="tab = 'services'"
          :class="tab === 'services' ? 'border-blue-500 text-blue-500' : 'text-gray-600 hover:text-blue-500'"
          class="pb-2 border-b-2 font-semibold"
        >Services</button>
      </nav>

      <!-- Overview Pane -->
      <!-- Overview Pane (replace your existing overview block with this) -->
<div x-show="tab === 'overview'" class="pt-6 space-y-4">
  <!-- Vertical list instead of grid -->
  <div class="space-y-3">
    <div class="flex items-center">
      <span class="font-semibold text-gray-700 w-40">Plate Number:</span>
      <span class="text-gray-900">{{ $car->plate_number }}</span>
    </div>
    <div class="flex items-center">
      <span class="font-semibold text-gray-700 w-40">Model:</span>
      <span class="text-gray-900">{{ $car->model }}</span>
    </div>
    <div class="flex items-center">
      <span class="font-semibold text-gray-700 w-40">Route:</span>
      <span class="text-gray-900">{{ $car->route }}</span>
    </div>
    <div class="flex items-center">
      <span class="font-semibold text-gray-700 w-40">Daily Hesabu Target:</span>
      <span class="text-gray-900">{{ number_format($car->daily_hesabu_target, 2) }}</span>
    </div>
    <div class="flex items-center">
      <span class="font-semibold text-gray-700 w-40">Supervisor:</span>
      @if($car->assigned_supervisor_id)
        <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
          {{ $car->supervisor->name ?? 'Unknown' }}
        </span>
      @else
        <span class="inline-block bg-pink-100 text-pink-700 font-bold px-3 py-1 rounded-full text-sm">
          No Supervisor
        </span>
      @endif
    </div>
  </div>

  <!-- Edit & Delete Buttons -->
  <div class="mt-6 flex space-x-3">
    <a href="{{ route('cars.edit', $car->id) }}"
       class="inline-flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
      <!-- Pencil Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 
                 002-2v-5m-3-4L5 21l-1-1L16 4l1 1z" />
      </svg>
      Edit
    </a>
    <form action="{{ route('cars.destroy', $car->id) }}" method="POST"
          onsubmit="return confirm('Delete this car?');">
      @csrf @method('DELETE')
      <button type="submit"
              class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
        <!-- Trash Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
        </svg>
        Delete
      </button>
    </form>
  </div>
</div>

      <!-- Daily Hesabu Pane -->
      <div x-show="tab === 'daily'" class="pt-6">
        @if($car->dailyHesabus->isEmpty())
          <p class="text-gray-500">No daily hesabu entries yet.</p>
        @else
          <table class="min-w-full border-collapse border border-gray-200">
            <thead>
              <tr class="bg-gray-100">
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Time</th>
              </tr>
            </thead>
            <tbody>
              @foreach($car->dailyHesabus as $h)
                <tr class="border-b">
                  <td class="border px-4 py-2">{{ number_format($h->amount,2) }}</td>
                  <td class="border px-4 py-2">{{ $h->description ?? '—' }}</td>
                  <td class="border px-4 py-2">{{ $h->collection_time->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <!-- Maintenance Pane -->
      <div x-show="tab === 'maintenance'" class="pt-6">
        @if($car->maintenances->isEmpty() && $car->inhouse_maintenance->isEmpty())
          <p class="text-gray-500">No maintenance records yet.</p>
        @else
          <ul class="space-y-2">
            @foreach($car->maintenances as $m)
              <li class="p-2 border rounded-md flex justify-between items-center">
                <span>{{ $m->type }} on {{ $m->performed_at->format('Y-m-d') }}</span>
                <a href="{{ route('maintenances.show', $m->id) }}"
                   class="text-blue-500 hover:underline text-sm">View</a>
              </li>
            @endforeach
            @foreach($car->inhouse_maintenance as $m)
              <li class="p-2 border rounded-md flex justify-between items-center">
                <span>In‑house: {{ $m->description }} ({{ $m->date->format('Y-m-d') }})</span>
                <a href="{{ route('inhouse-maintenance.show', $m->id) }}"
                   class="text-blue-500 hover:underline text-sm">View</a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      <!-- Services Pane -->
      <div x-show="tab === 'services'" class="pt-6">
        @if($car->services->isEmpty())
          <p class="text-gray-500">No service records yet.</p>
        @else
          <table class="min-w-full border-collapse border border-gray-200">
            <thead>
              <tr class="bg-gray-100">
                <th class="border px-4 py-2">Type</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Next Due</th>
              </tr>
            </thead>
            <tbody>
              @foreach($car->services as $s)
                <tr class="border-b">
                  <td class="border px-4 py-2">{{ ucfirst($s->service_type) }}</td>
                  <td class="border px-4 py-2">{{ $s->date_performed->format('Y-m-d') }}</td>
                  <td class="border px-4 py-2">{{ optional($s->next_due_date)->format('Y-m-d') ?? '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
