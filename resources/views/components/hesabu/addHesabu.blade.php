<x-app-layout>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-blue-500 mb-4">Daily Hesabu</h1>

        <p class="text-gray-700 mb-6">Enter the daily hesabu for each car. If the amount is less than the target, provide a reason.</p>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Car</th>
                        <th class="border px-4 py-2 text-left">Target</th>
                        <th class="border px-4 py-2 text-left">Amount</th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $car)
                        <tr>
                            <td class="border px-4 py-2">{{ $car->plate_number }} - {{ $car->model }}</td>
                            <td class="border px-4 py-2">{{ $car->daily_hesabu_target }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('daily-hesabu.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                                    <input type="number" name="amount" step="0.01" min="0"
                                           class="w-full border rounded-md px-2 py-1 focus:ring-blue-500 focus:border-blue-500" required>
                            </td>
                            <td class="border px-4 py-2">
                                    <input type="text" name="description" placeholder="Optional"
                                           class="w-full border rounded-md px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                            </td>
                            <td class="border px-4 py-2">
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-500 text-white rounded-md shadow-sm hover:bg-blue-600">
                                        Submit
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
