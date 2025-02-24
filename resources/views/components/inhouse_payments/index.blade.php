<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">In-House Maintenance Summary</h2>

        {{-- Display total maintenance cost for all cars --}}
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md mb-6">
            <h3 class="text-xl font-semibold">Total Maintenance Cost</h3>
            <p class="text-2xl font-bold mt-2">TSh {{ number_format($totalMaintenance, 2) }}</p>
        </div>

        {{-- Table of cars with their total maintenance cost --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold mb-4">Maintenance Breakdown by Car</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Car</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase">Total Cost (TSh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-600">{{ $car->plate_number }}</td>
                                <td class="px-6 py-4 text-gray-800 font-semibold">TSh {{ number_format($car->total_maintenance, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payment Section --}}
        <div class="bg-gray-50 p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Make a Payment</h3>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('makePayment') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="amount" class="block text-gray-600 font-medium">Enter Payment Amount (TSh)</label>
                    <input type="number" id="amount" name="amount" min="1" step="0.01" required
                        class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Make Payment
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
