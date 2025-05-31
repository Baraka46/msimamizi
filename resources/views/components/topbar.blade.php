<div class="fixed top-0 left-0 w-full h-16 bg-white shadow z-40 flex items-center justify-between px-4 lg:px-64">

  <button @click="isSidebarOpen = !isSidebarOpen" class="lg:hidden text-gray-700">
    <i :class="isSidebarOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i>
  </button>

  <div class="text-center text-lg font-bold text-blue-700">
    <span>CVMS Control Panel</span>
  </div>


  <div class="flex items-center space-x-3">
    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
    <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar" class="w-8 h-8 rounded-full">
  </div>
</div>