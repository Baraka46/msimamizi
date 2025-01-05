<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-900">

<div class="flex justify-center items-center min-h-screen bg-blue-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <form action="{{ route('register.handleStep') }}" method="POST">
            @csrf

            @if ($step == 1)
                <input type="hidden" name="step" value="1">

                <h2 class="text-2xl font-semibold text-blue-500 mb-6">Step 1: Register Your Company</h2>

                <label for="name" class="block text-sm font-medium text-gray-700">Company Name:</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <label for="email" class="block text-sm font-medium text-gray-700 mt-4">Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <label for="address" class="block text-sm font-medium text-gray-700 mt-4">Address:</label>
                <input type="text" name="address" value="{{ old('address') }}" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <button type="submit" class="w-full mt-6 py-3 bg-pink-600 text-white font-semibold rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50">Next</button>
            @elseif ($step == 2)
                <input type="hidden" name="step" value="2">
                <h2 class="text-2xl font-semibold text-blue-500 mb-6">Step 2: Register the Owner</h2>

                <input type="hidden" name="company_email" value="{{ $companyEmail }}">

                <label for="name" class="block text-sm font-medium text-gray-700">Owner Name:</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <label for="email" class="block text-sm font-medium text-gray-700 mt-4">Owner Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <label for="password" class="block text-sm font-medium text-gray-700 mt-4">Password:</label>
                <input type="password" name="password" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mt-4">Confirm Password:</label>
                <input type="password" name="password_confirmation" required class="w-full p-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <button type="submit" class="w-full mt-6 py-3 bg-pink-600 text-white font-semibold rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-opacity-50">Register</button>
            @endif
        </form>
    </div>
</div>

</body>
</html>
