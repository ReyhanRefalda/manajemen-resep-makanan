<nav x-data="{ open: false }" class="bg-[#FB773C] text-white w-64 h-screen fixed">
    <!-- Primary Navigation Menu -->
    <div class="p-4">
        <div class="shrink-0 flex items-center">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-white" />
            </a>
        </div>

        <!-- Navigation Links -->
        <div class="mt-10 space-y-2">
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
        </div>
    </div>
</nav>
