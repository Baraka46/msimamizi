<x-app-layout>
    <!-- Dashboard Content -->
    <div class="p-6">
        <!-- Dashboard Header -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-gray-600">Welcome back! Here's a summary of your data:</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Cars -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-blue-800">Total Cars</h2>
                <p class="text-3xl font-bold">25</p> <!-- Fake Data -->
            </div>

            <!-- Profit -->
            <div class="bg-green-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-green-800">Total Profit</h2>
                <p class="text-3xl font-bold">$12,500</p> <!-- Fake Data -->
            </div>

            <!-- Expenses -->
            <div class="bg-red-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-red-800">Total Expenses</h2>
                <p class="text-3xl font-bold">$3,200</p> <!-- Fake Data -->
            </div>
        </div>
    </div>
</x-app-layout>
