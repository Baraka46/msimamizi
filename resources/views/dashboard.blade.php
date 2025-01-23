<x-app-layout>
    <div class="p-6">
        <!-- Greeting Header -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold">Hello, {{ $user->name }}</h1>
            <p class="text-gray-600"></p>
        </div>

        <!-- Dashboard Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @if($user->role === 'admin')
                <!-- Admin Content -->
                <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-blue-800">Manage Users</h2>
                    <p class="text-3xl font-bold">150</p> <!-- Fake data -->
                </div>


                @elseif ($role === 'supervisor')
    <!-- Supervisor Dashboard -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-full">
        <!-- Flex container to arrange the inner divs -->
        <div class="flex flex-col sm:flex-row gap-6 w-full justify-between">
            <!-- Total Assigned Cars -->
            <div class="flex-1 min-w-[250px] bg-yellow-100 p-6 rounded-lg shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-yellow-200 text-center">
                <h3 class="text-xl font-semibold text-yellow-800 mb-2">Assigned Cars</h3>
                <p class="text-4xl font-bold text-yellow-900">{{ $assignedCarsCount }}</p>
            </div>

            <!-- Total Maintenance Expenses -->
            <div class="flex-1 min-w-[250px] bg-red-100 p-6 rounded-lg shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-red-200 text-center">
                <h3 class="text-xl font-semibold text-red-800 mb-2">Total Maintenance Expenses</h3>
                <p class="text-4xl font-bold text-red-900">{{ number_format($totalMaintenanceExpenses, 2) }} Tsh</p>
            </div>

            <!-- Total Hesabu Collected -->
            <div class="flex-1 min-w-[250px] bg-blue-100 p-6 rounded-lg shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl hover:bg-blue-200 text-center">
                <h3 class="text-xl font-semibold text-blue-800 mb-2">Total Hesabu Collected</h3>
                <p class="text-4xl font-bold text-blue-900">{{ number_format($totalHesabuCollected, 2) }} Tsh</p>
            </div>
        </div>
    </div>









   
            @elseif($user->role === 'owner')
                <!-- Owner Content -->
                 
                <div class="bg-red-100 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-red-800">Properties Managed</h2>
                    <p class="text-3xl font-bold">5</p> <!-- Fake data -->
                </div>
            @else
                <p class="text-red-500">Invalid role. Please contact the system administrator.</p>
            @endif
        </div>
    </div>
</x-app-layout>
