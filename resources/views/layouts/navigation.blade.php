<nav x-data="{ open: false }" class="bg-[#FB773C] text-white w-64 h-screen fixed">
    <!-- Primary Navigation Menu -->
    <div class="p-4">
        <div class="shrink-0 flex items-center justify-center">
            <a href="{{ route('dashboard') }}" class=""> <!-- Menambahkan margin kiri -->
                <img src="{{ asset('logo/logo2r.png') }}" class="fill-current text-gray-500" style="width: 80px; height:80px;" alt="">
            </a>
        </div>

        <!-- Garis pemisah -->
        <hr class="my-4 border-t border-white">

        <!-- Navigation Links -->
        <div class="mt-5 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('dashboard') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> <!-- Ikon Dashboard -->
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('resep.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('resep.index') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-receipt mr-2"></i> <!-- Ikon Resep -->
                {{ __('Resep') }}
            </a>
            <a href="{{ route('bahan.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('bahan.index') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-basket-shopping mr-2"></i> <!-- Ikon Bahan -->
                {{ __('Bahan') }}
            </a>
            <a href="{{ route('kategori.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('kategori.index') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-tags mr-2"></i> <!-- Ikon Kategori -->
                {{ __('Kategori') }}
            </a>
            <a href="{{ route('pembuat.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('pembuat.index') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-user-friends mr-2"></i> <!-- Ikon Pembuat -->
                {{ __('Pembuat') }}
            </a>
            <a href="{{ route('langkah.index') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('langkah.index') ? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-tasks mr-2"></i> <!-- Ikon Langkah -->
                {{ __('Langkah') }}
            </a>

            <hr class="my-4 border-t border-white">

            <a href="{{ route('profile.edit') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('profile.edit') }}? 'bg-[#e36b33]' : '' }}">
                <i class="fas fa-user mr-2"></i> 
                {{ Auth::user()->name }}
            </a>
        
                <!-- Autentikasi -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                  class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-white hover:text-[#FB773C] {{ request()->routeIs('logout') }}? 'bg-[#e36b33]' : '' }}"
                   onclick="event.preventDefault();
                                this.closest('form').submit();">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>
                    {{ __('Log Out') }}
                </a>
            </form>
           
        </div>
    </div>
</nav>
