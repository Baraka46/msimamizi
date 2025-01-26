<x-app-layout>
    <div class="bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-blue-500 mb-4">Daily Hesabu</h1>
        <p class="text-gray-700 mb-6">Enter the daily hesabu for each car. If the amount is less than the target, provide a reason.</p>

        <!-- Unfilled Cars Form -->
        <div class="overflow-x-auto mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Unfilled Cars</h2>

    @if ($unfilledCars->isEmpty())
        <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-4">
            <p class="font-semibold">Your job today is done! 🎉</p>
        </div>
    @else
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
                @foreach ($unfilledCars as $car)
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
    @endif
</div>

        <!-- Filled Cars Table -->
        <div class="overflow-x-auto">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Filled Cars</h2>
            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Car</th>
                        <th class="border px-4 py-2 text-left">Target</th>
                        <th class="border px-4 py-2 text-left">Amount</th>
                        <th class="border px-4 py-2 text-left">Description</th>
                        <th class="border px-4 py-2 text-left">Collection Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filledCars as $car)
                        <tr>
                            <td class="border px-4 py-2">{{ $car->plate_number }} - {{ $car->model }}</td>
                            <td class="border px-4 py-2">{{ $car->daily_hesabu_target }}</td>
                            <td class="border px-4 py-2">{{ $car->dailyHesabus->first()->amount }}</td>
                            <td class="border px-4 py-2">{{ $car->dailyHesabus->first()->description ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">{{ $car->dailyHesabus->first()->collection_time->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</x-app-layout>
