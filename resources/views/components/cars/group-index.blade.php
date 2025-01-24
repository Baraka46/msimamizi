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

        <!-- Groups Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cars</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($carGroups as $group)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group->description ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($group->cars->count() > 0)
                                    <ul class="list-disc list-inside">
                                        @foreach ($group->cars as $car)
                                            <li>{{ $car->plate_number }} ({{ $car->route}})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    No cars assigned.
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-2">
                                    <a href="" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit</a>
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this group?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No car groups found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>