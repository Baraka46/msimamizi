<x-app-layout>
    <div class="container mx-auto p-6 my-5">
        <h1 class="text-2xl font-semibold mb-6">Car Groups</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Group Button -->
        <div class="mb-6">
            <a href="{{ route('GroupCreate.create') }}" class="px-6 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Create New Group
            </a>
        </div>

        <!-- Groups and Expenses -->
        <div class="space-y-6">
            @forelse ($carGroups as $group)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <!-- Group Header -->
                    <h2 class="text-xl font-semibold mb-4">{{ $group->name }}</h2>
                    <p class="text-gray-500 mb-4">{{ $group->description ?? 'No description provided.' }}</p>

                    <!-- Cars -->
                    <h3 class="text-lg font-semibold mb-2">Cars</h3>
                    @if ($group->cars->count() > 0)
                        <ul class="list-disc list-inside mb-4">
                            @foreach ($group->cars as $car)
                                <li>{{ $car->plate_number }} ({{ $car->route }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 mb-4">No cars assigned to this group.</p>
                    @endif

                    <!-- Expenses -->
                    <h3 class="text-lg font-semibold mb-2">Expenses</h3>
                    <a href="{{ route('expenses.index', $group->id) }}">
                    @if ($group->groupExpenses->count() > 0)
                        <ul class="list-disc list-inside mb-4">
                            @foreach ($group->groupExpenses as $expense)
                                <li>
                                    <span class="font-medium">{{ $expense->name }}</span> - 
                                    {{ number_format($expense->amount) }} 
                                    <span class="">{{ $expense->collection_interval ?? 'No description' }} days</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 mb-4">No expenses recorded for this group.</p>
                    @endif
                    </a>
                    <!-- Add Expense Button -->
                    <a href="{{ route('expenses.create', $group->id) }}" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Add Expense
                    </a>
                </div>
            @empty
                <div class="text-gray-500 text-center">No car groups found.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
