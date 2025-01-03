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
            @elseif($user->role === 'supervisor')
                <!-- Supervisor Content -->
                <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-yellow-800">Tasks Assigned</h2>
                    <p class="text-3xl font-bold">12</p> <!-- Fake data -->
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
