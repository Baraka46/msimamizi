<!-- resources/views/users/create_supervisor.blade.php -->

<x-app-layout>
<form action="{{ route('supervisors.store') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input 
            type="text" 
            name="name" 
            id="name" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Enter supervisor name" 
            required>
        @error('name')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input 
            type="email" 
            name="email" 
            id="email" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Enter supervisor email" 
            required>
        @error('email')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Phone Field -->
    <div>
        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone</label>
        <input 
            type="text" 
            name="phone_number" 
            id="phone_number" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Enter phone number" 
            required>
        @error('phone_number')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Address Field -->
    <div>
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <textarea 
            name="address" 
            id="address" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            rows="3" 
            placeholder="Enter address" 
            required></textarea>
        @error('address')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input 
            type="password" 
            name="password" 
            id="password" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Enter password" 
            required>
        @error('password')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password Field -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input 
            type="password" 
            name="password_confirmation" 
            id="password_confirmation" 
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Re-enter password" 
            required>
        @error('password_confirmation')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <!-- Submit Button -->
    <div>
        <button 
            type="submit" 
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
            Create Supervisor
        </button>
    </div>
</form>

</x-app-layout>
