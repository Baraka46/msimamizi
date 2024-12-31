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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supervisors as $index => $supervisor)
                            <tr 
                                class="border-b hover:bg-gray-50 cursor-pointer" 
                                onclick="openModal({{ json_encode($supervisor) }})">
                                <td class="px-4 py-2">{{ $supervisor->name }}</td>
                                <td class="px-4 py-2">{{ $supervisor->email }}</td>
                                <td class="px-4 py-2">{{ ucfirst($supervisor->phone_number) }}</td>
                                <td class="px-4 py-2">{{ $supervisor->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cards for Small Screens -->
                <div class="sm:hidden">
                    @foreach($supervisors as $index => $supervisor)
                        <div 
                            class="bg-gray-50 border border-gray-200 rounded-lg mb-4 p-4 shadow cursor-pointer"
                            onclick="openModal({{ json_encode($supervisor) }})">
                            <h2 class="text-lg font-bold">Supervisor {{ $index + 1 }}</h2>
                            <p><strong>Name:</strong> {{ $supervisor->name }}</p>
                            <p><strong>Email:</strong> {{ $supervisor->email }}</p>
                            <p><strong>Contact:</strong> {{ ucfirst($supervisor->phone_number) }}</p>
                            <p><strong>Address:</strong> {{ $supervisor->address }}</p>
                        </div>
                    @endforeach
                </div>
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
    <!-- Disable Button -->
    @foreach($supervisors as $supervisor)
    <form method="POST" action="{{ route('supervisors.disable', ['id' => $supervisor->id]) }}" id="disableForm">
        @csrf
        @method('PATCH')
        <button type="submit" 
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition"
                onclick="return confirm('Are you sure  you want to diable this supervisor?')">
                
            Disable
        </button>
    </form>
    @endforeach

    <!-- Edit Info Button -->
    <a id="editLink" href="#" 
       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
        Edit Info
    </a>
</div>
<button onclick="closeModal()" 
        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
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

            // Display the modal
            document.getElementById('supervisorModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('supervisorModal').classList.add('hidden');
        }

        window.addEventListener('click', function (e) {
            if (e.target.id === 'supervisorModal') {
                closeModal();
            }
        });

        // Disable Supervisor Function
        
    </script>
    <!-- Disabled Supervisors Section -->
<div class="container mx-auto my-5 p-4 bg-white shadow rounded-lg">
    <h1 class="text-2xl font-bold mb-6">Disabled Supervisors</h1>
    @if($disabledSupervisors->isEmpty())
        <p class="text-gray-500">No disabled supervisors available.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
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
    @endif
</div>

</x-app-layout>