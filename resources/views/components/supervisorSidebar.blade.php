<!-- Sidebar Section -->
<div x-data="{ isSidebarOpen: window.innerWidth >= 1024 }" class="relative">
    <!-- Sidebar Button (Visible only on small screens) -->
    <div 
        :class="isSidebarOpen ? 'lg:hidden absolute top-4 left-64' : 'lg:hidden absolute top-4 left-4'" 
        class="transition-all duration-300 ease-in-out z-50">
        <button 
            @click="isSidebarOpen = !isSidebarOpen" 
            class="text-black p-3 rounded-full">
            <i :class="isSidebarOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <div 
        :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
        class="fixed bg-blue-800 text-white w-64 h-full p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:translate-x-0 z-30">
        
        <!-- Logo Section -->
         <div>
        <div class="logo mb-10">
            <h2 class="text-3xl font-bold text-center">msiamizi</h2>
       

        <!-- User Profile (Optional) -->
        <!-- <nav x-data="{ showProfileMenu: false }" class="bg-blue-400 p-4 w-200 rounded-lg shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center space-x-4">
               
                <img 
                    src="https://via.placeholder.com/50" 
                    alt="Profile Picture" 
                    class="rounded-full w-12 h-12 cursor-pointer" 
                    @click="showProfileMenu = !showProfileMenu">

              
                <div 
                    class="flex flex-col cursor-pointer" 
                    @click="showProfileMenu = !showProfileMenu">
                    <p class="font-semibold text-base truncate w-[150px] sm:w-auto">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-sm">
                        {{ Auth::user()->role }}
                    </p>
                </div>
            </div>

           
            <div 
                x-show="showProfileMenu" 
                @click.outside="showProfileMenu = false" 
                class="absolute left-4 bg-white border border-gray-200 rounded-md shadow-lg z-50 w-48 mt-16">
                <x-dropdown-link href="{{ route('profile.show') }}">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</nav> -->
</div>

        <!-- Sidebar Navigation Links -->
        <ul class="space-y-4">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <a href="#" 
   onclick="toggleDropdown(event, 'bus-management-dropdown')" 
   class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
    <i class="fas fa-bus"></i>
    <span>Bus Management</span>
   
</a>

<!-- Dropdown Items -->
<ul id="bus-management-dropdown" 
    class="hidden flex flex-col space-y-1 pl-8 mt-2">
    <li>
        <a href="{{route('daily-hesabu.index')}}" 
           class="flex items-center px-4 py-2 hover:bg-blue-500 hover:text-white rounded-lg transition">
           <i class="fas fa-money-bill-alt mr-2"></i>
            Hesabu
        </a>
    </li>
    <li>
        <a href="{{ route('cars.index') }}" 
           class="flex items-center px-4 py-2 hover:bg-blue-500 hover:text-white rounded-lg transition">
            <i class="fas fa-bus mr-2"></i> <!-- Bus Icon -->
            Bus
        </a>
    </li>
    <li>
        <a href="{{ route('GroupIndex.index') }}" 
           class="flex items-center px-4 py-2 hover:bg-blue-500 hover:text-white rounded-lg transition">
            <i class="fas fa-users mr-2"></i> <!-- Person Icon -->
            Groups
        </a>
    </li>
</ul>

            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
                    <i class="fas fa-wallet"></i>
                    <span>Expenses</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
                    <i class="fas fa-chart-line"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('services.index') }}" class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
                    <i class="fas fa-cogs"></i>
                    <span>Services</span>
                </a>
            </li>
            <li>
    <a href="#" 
       onclick="toggleDropdown(event, 'maintenance-dropdown')" 
       class="flex items-center space-x-3 hover:bg-blue-700 p-2 rounded-lg transition">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <span>Maintenance</span>
       
    </a>

    <!-- Dropdown Items -->
    <ul id="maintenance-dropdown" class="hidden flex flex-col space-y-1 pl-8 mt-2">
        <li>
            <a href="{{route('in-house-maintenance.index')}}" 
               class="flex items-center px-4 py-2 hover:bg-blue-500 hover:text-white rounded-lg transition">
                <i class="fas fa-tools mr-2"></i> <!-- Inhouse Icon -->
                Inhouse Maintenance
            </a>
        </li>
        <li>
            <a href="{{route('maintenances.index')}}" 
               class="flex items-center px-4 py-2 hover:bg-blue-500 hover:text-white rounded-lg transition">
                <i class="fas fa-wrench mr-2"></i> <!-- Outside Icon -->
                Outside Maintenance
            </a>
        </li>
    </ul>
</li>

        </ul>
        </div>
    </div>
</div>
