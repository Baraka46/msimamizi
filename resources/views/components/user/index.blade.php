<x-app-layout>
    <div class="container mx-auto my-5 p-4 bg-white shadow rounded-lg">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Supervisors List</h1>
            <a href="{{ route('supervisors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Add Supervisor
            </a>
        </div>

        <!-- Table Section -->
        @if($supervisors->isEmpty())
            <p class="text-gray-500">No supervisors available.</p>
        @else
            <div class="overflow-x-auto">
                <!-- Table for Larger Screens -->
                <table class="hidden sm:table min-w-full bg-white border border-gray-200">
        <thead>
    <tr class="bg-gray-100 border-b">
        <th class="text-left px-4 py-2">Name</th>
        <th class="text-left px-4 py-2">Email</th>
        <th class="text-left px-4 py-2">Contact</th>
        <th class="text-left px-4 py-2">Address</th>
        <th class="text-left px-4 py-2">Actions</th> <!-- New column for actions -->
    </tr>
</thead>
<tbody>
    @foreach($supervisors as $index => $supervisor)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ $supervisor->name }}</td>
            <td class="px-4 py-2">{{ $supervisor->email }}</td>
            <td class="px-4 py-2">{{ ucfirst($supervisor->phone_number) }}</td>
            <td class="px-4 py-2">{{ $supervisor->address }}</td>
            <td class="px-4 py-2 text-right">
            <button onclick="openModal({{ json_encode($supervisor) }})"
        class="text-gray-600 hover:text-gray-900 focus:outline-none">
    <!-- Three dots icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v.01M12 12v.01M12 18v.01" />
    </svg>
</button>

            </td>
        </tr>
    @endforeach
</tbody>

                </table>

                <!-- Cards for Small Screens -->
                <div class="sm:hidden">
    @foreach($supervisors as $index => $supervisor)
        <div class="bg-gray-50 border border-gray-200 rounded-lg mb-4 p-4 shadow">
            <h2 class="text-lg font-bold flex justify-between items-center">
                Supervisor {{ $index + 1 }}
                <button onclick="openModal({{ json_encode($supervisor) }})"
        class="text-gray-600 hover:text-gray-900 focus:outline-none">
    <!-- Three dots icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v.01M12 12v.01M12 18v.01" />
    </svg>
</button>

            </h2>
            <p><strong>Name:</strong> {{ $supervisor->name }}</p>
            <p><strong>Email:</strong> {{ $supervisor->email }}</p>
            <p><strong>Contact:</strong> {{ ucfirst($supervisor->phone_number) }}</p>
            <p><strong>Address:</strong> {{ $supervisor->address }}</p>
        </div>
    @endforeach
</div>

        @endif
    </div>

    <!-- Modal -->
    <div id="supervisorModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h2 id="modalTitle" class="text-lg font-bold mb-4">Supervisor Details</h2>
        <div id="modalContent" class="mb-4">
            <p><strong>Name:</strong> <span id="modalName"></span></p>
            <p><strong>Email:</strong> <span id="modalEmail"></span></p>
            <p><strong>Contact:</strong> <span id="modalContact"></span></p>
            <p><strong>Address:</strong> <span id="modalAddress"></span></p>
        </div>
        <div class="flex justify-end space-x-3">
            <!-- Disable Button (Only for the selected supervisor) -->
            <form id="disableForm" method="POST" action="" class="hidden">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-600 transition"
                        onclick="return confirm('Are you sure you want to disable this supervisor?')">
                    Disable
                </button>
            </form>

            <!-- Edit Info Button -->
            <a id="editLink" href="#" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                Edit Info
            </a>
            <!-- View Supervisor Button -->
            <a id="viewSupervisorLink" href="#" 
   class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 transition">
   View 
</a>


        </div>
        <button onclick="closeModal()" 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition mt-2">
            Close
        </button>
    </div>
</div>


    <!-- Script -->
    <script>
let currentSupervisor = null;

function openModal(supervisor) {
    currentSupervisor = supervisor;

    // Update modal content
    document.getElementById('modalTitle').innerText = `Supervisor Details - ${supervisor.name}`;
    document.getElementById('modalName').innerText = supervisor.name;
    document.getElementById('modalEmail').innerText = supervisor.email;
    document.getElementById('modalContact').innerText = supervisor.phone_number;
    document.getElementById('modalAddress').innerText = supervisor.address;

    // Update the links for Edit
    document.getElementById('editLink').href = `/supervisors/${supervisor.id}/edit`;

    // Update the Disable button's form action dynamically
    document.getElementById('disableForm').action = `/supervisors/${supervisor.id}/disable`;

    document.getElementById('viewSupervisorLink').href = `/supervisors/${supervisor.id}`;

    // Show the Disable button in the modal
    document.getElementById('disableForm').classList.remove('hidden');

    // Display the modal
    document.getElementById('supervisorModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('supervisorModal').classList.add('hidden');
    document.getElementById('disableForm').classList.add('hidden'); // Hide the form when closing the modal
}

window.addEventListener('click', function (e) {
    if (e.target.id === 'supervisorModal') {
        closeModal();
    }
});

        
    </script>
    <!-- Disabled Supervisors Section -->
    <div class="container mx-auto my-5 p-4 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6">Disabled Supervisors</h1>
    @if($disabledSupervisors->isEmpty())
        <p class="text-gray-500">No disabled supervisors available.</p>
    @else
        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 hidden md:table">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="text-left px-4 py-2">Name</th>
                        <th class="text-left px-4 py-2">Email</th>
                        <th class="text-left px-4 py-2">Contact</th>
                        <th class="text-left px-4 py-2">Address</th>
                        <th class="text-left px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($disabledSupervisors as $supervisor)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $supervisor->name }}</td>
                            <td class="px-4 py-2">{{ $supervisor->email }}</td>
                            <td class="px-4 py-2">{{ ucfirst($supervisor->phone_number) }}</td>
                            <td class="px-4 py-2">{{ $supervisor->address }}</td>
                            <td class="px-4 py-2">
                                <!-- Enable Button -->
                                <form method="post" action="{{ route('supervisors.enable', ['id' => $supervisor->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
                                            onclick="return confirm('Are you sure you want to enable this supervisor?')">
                                        Enable
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="block md:hidden space-y-4">
            @foreach($disabledSupervisors as $supervisor)
                <div class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm">
                    <p><strong>Name:</strong> {{ $supervisor->name }}</p>
                    <p><strong>Email:</strong> {{ $supervisor->email }}</p>
                    <p><strong>Contact:</strong> {{ ucfirst($supervisor->phone_number) }}</p>
                    <p><strong>Address:</strong> {{ $supervisor->address }}</p>
                    <div class="mt-3">
                        <!-- Enable Button -->
                        <form method="post" action="{{ route('supervisors.enable', ['id' => $supervisor->id]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition w-full"
                                    onclick="return confirm('Are you sure you want to enable this supervisor?')">
                                Enable
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</x-app-layout>