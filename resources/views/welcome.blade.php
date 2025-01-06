<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

    <!-- Navbar -->
    
    <nav class="flex justify-between items-center px-6 py-4 bg-blue-500 text-white">
        <h1 class="text-2xl font-bold">Transport Manager</h1>
        <div class="space-x-4">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="bg-pink-500 hover:bg-pink-600 px-4 py-2 rounded shadow text-white"
                                    >
                                        Log in   
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="bg-white hover:bg-gray-100 px-4 py-2 rounded shadow text-blue-500"
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                                </div>
                            </nav>
                            
       
                           

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-500 via-blue-400 to-pink-200 text-white text-center py-20">
        <h1 class="text-5xl font-bold">Effortlessly Manage Your Transport Business</h1>
        <p class="mt-4 text-lg">Track daily income, manage expenses, and view weekly profits with ease.</p>
        <div class="mt-6">
            <a href="{{ url('/company/register') }}" class="bg-pink-500 hover:bg-pink-600 px-6 py-3 rounded shadow text-white">Get Started</a>
            <a href="#features" class="bg-white text-blue-500 hover:bg-gray-100 px-6 py-3 rounded shadow ml-4">Learn More</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-blue-50">
        <div class="container mx-auto text-center px-4">
            <h2 class="text-3xl font-bold text-blue-500">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <!-- Feature 1 -->
                <div class="bg-white shadow rounded p-6 hover:shadow-lg transition-shadow">
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m4 0h5m-11 4h5m-2 4h3M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Daily Income Tracking</h3>
                    <p>Supervisors can log Hesabu for each bus daily.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white shadow rounded p-6 hover:shadow-lg transition-shadow">
                    <div class="text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M4 6h16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Expense Management</h3>
                    <p>Log maintenance and operational expenses with ease.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white shadow rounded p-6 hover:shadow-lg transition-shadow">
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m-2-2v6m0-6v-6a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1h4a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Profit Insights</h3>
                    <p>View weekly profit/loss reports for the fleet.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-500 text-white text-center py-8">
        <p class="text-lg">Start managing your transport business today!</p>
       
    </footer>

</body>
</html>
