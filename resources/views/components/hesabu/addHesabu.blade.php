<x-app-layout>
    
    <div class="bg-white p-6 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-blue-500 mb-4">Daily Income</h1>
        <p class="text-gray-700 mb-6">Enter the daily income for each car. If the amount is less than the target, provide a reason.</p>

        <!-- Unfilled Cars Form -->
        <div class="overflow-x-auto mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Unfilled Cars </h2>
   

    @if ($unfilledCars->isEmpty())
        <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-4">
            <p class="font-semibold">Your job today is done! 🎉</p>
        </div>
    @else
    <h3 class="text-xl  text-red-500 mb-4"> ⚠️ fill one by one</h3>
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
                        <th class="border px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filledCars as $car)
                      @php
    $hesabu = $car->dailyHesabus->first();
@endphp
<tr x-data="editRow({{ $hesabu->id }}, {{ $car->daily_hesabu_target }}, {{ $hesabu->amount }}, '{{ $hesabu->description ?? '' }}')">
    <td class="border px-4 py-2">{{ $car->plate_number }} - {{ $car->model }}</td>
    <td class="border px-4 py-2">{{ $car->daily_hesabu_target }}</td>

    <td class="border px-4 py-2">
        <template x-if="!editing">
          <span x-show="!editing" x-text="Number(amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })"></span>

        </template>
        <template x-if="editing">
            <input type="number" x-model="amount" step="0.01" class="w-full border rounded px-2 py-1" />
        </template>
    </td>

    <td class="border px-4 py-2">
        <template x-if="!editing">
            <span x-text="description || 'N/A'"></span>
        </template>
        <template x-if="editing">
            <input type="text" x-model="description" class="w-full border rounded px-2 py-1" />
        </template>
    </td>

    <td class="border px-4 py-2 whitespace-nowrap">
        <span>{{ $hesabu->collection_time->format('Y-m-d H:i:s') }}</span>
    </td>

    <td class="border px-4 py-2 whitespace-nowrap text-right">
        <template x-if="!editing">
            <button @click="editing = true" class=" bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</button>
        </template>
        <template x-if="editing">
            <div class="flex gap-2">
                <button @click="save" class=" bg-green-500 text-white px-3 py-1 rounded hover:bg-green-700">Save</button>
                <button @click="cancel" class=" bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-500">Cancel</button>
            </div>
        </template>
    </td>
</tr>

                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
    <script>
function editRow(id, target, initialAmount, initialDescription) {
    return {
        editing: false,
        originalAmount: initialAmount,
        originalDescription: initialDescription,
        amount: initialAmount,
        description: initialDescription,
     save() {
    axios.put(`/daily-hesabu/${id}`, {
        amount: this.amount,
        description: this.amount < target ? this.description : null,
    }).then(() => {
        // 💡 These lines make sure the visible text updates immediately
        this.originalAmount = this.amount;
        this.originalDescription = this.description;

        this.editing = false;
    }).catch(error => {
        alert('Update failed');
        console.error(error);
    });
}
,
        cancel() {
            this.amount = this.originalAmount;
            this.description = this.originalDescription;
            this.editing = false;
        }
    }
}
</script>

</x-app-layout>
