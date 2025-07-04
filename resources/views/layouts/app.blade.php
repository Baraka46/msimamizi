<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
         <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @livewireStyles
    </head>
 <body class="font-sans antialiased"  x-data="{ isSidebarOpen: window.innerWidth >= 1024 }">
  <script>
    function toggleDropdown(event, dropdownId) {
      event.preventDefault();
      const dropdown = document.getElementById(dropdownId);
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
    }
  </script>

  <x-banner />

  <div class="min-h-screen">
 <!-- @include('components.topbar') -->

  <div class="min-h-screen">
 
 <div
      x-show="isSidebarOpen"
      @click="isSidebarOpen = false"
      class="fixed inset-0 bg-black bg-opacity-25 z-40 lg:hidden"
      x-transition.opacity
    ></div>
    <!-- Page Layout -->
    <div class="flex flex-nowrap">    <!-- prevent wrapping -->
      <!-- Sidebar -->
      <div class="w-50 md:w-64 flex-shrink-0 bg-gray-100 text-white h-screen"
      
      >
        @switch(Auth::user()->role)
          @case('owner')
            @include('components.ownerSidebar')
            @break
          @case('supervisor')
            @include('components.supervisorSidebar')
            @break
          @case('user')
            @include('components.userSidebar')
            @break
          @case('admin')
            @include('components.adminSidebar')
            @break
        @endswitch
      </div>

      <!-- Main Content -->
      <main class="flex-1 p-6 mt-4 min-w-0 overflow-auto break-words">
        {{ $slot }}
      </main>
    </div>
  </div>

  @stack('modals')

  @livewireScripts
</body>