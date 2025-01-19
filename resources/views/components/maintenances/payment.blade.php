<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-6">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-6">Payments for {{ $maintenance->expense_name }}</h1>
        <p class="text-lg text-gray-700 mb-2">Car: <span class="font-semibold text-indigo-600">{{ $maintenance->car->plate_number }}</span></p>
        <p class="text-lg text-gray-700 mb-2">Cost: <span class="font-semibold text-green-500">{{ $maintenance->cost }}</span></p>
        <p class="text-lg text-gray-700 mb-6">Outstanding Balance: 
            <span class="font-semibold 
                {{ $maintenance->outstanding_balance == 0 ? 'text-green-500' : 'text-red-500' }}">
                {{ $maintenance->outstanding_balance == 0 ? 'Fully Paid' : $maintenance->outstanding_balance }}
            </span>
        </p>

        <!-- Table displaying previous payments -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="border-t hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $payment->amount }}</td>
                            <td class="px-6 py-4">{{ $payment->payment_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Show payment form only if there's an outstanding balance -->
        @if($maintenance->outstanding_balance > 0)
            <div class="mt-6">
                <form method="POST" action="{{ route('maintenances.addPayment', $maintenance) }}" class="bg-gray-100 p-4 rounded-lg shadow-md">
                    @csrf
                    <h2 class="text-xl font-semibold mb-4">Add a New Payment</h2>
                    <div class="flex space-x-4 mb-4">
                        <input type="number" name="amount" placeholder="Payment Amount" required class="p-3 border rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <input type="date" name="payment_date" required class="p-3 border rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Add Payment</button>
                </form>
            </div>
        @else
            <p class="text-green-500 font-semibold mt-6">The maintenance is fully paid.</p>
        @endif
    </div>
</x-app-layout>
