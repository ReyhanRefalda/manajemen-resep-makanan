<x-app-layout>
    <div class="container mx-auto">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            
        </x-slot>
        <div class="flex justify-center m-6">
            <form action="{{ route('dashboard') }}" method="GET" class="relative w-full max-w-md">
                <input type="text" name="search" placeholder="Cari Resep..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" value="{{ request()->get('search') }}" />
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
            @forelse($reseps as $resep)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}">
                <div class="p-4">
                    <h3 class="text-lg font-bold">{{ $resep->nama }}</h3>
                    <p class="text-gray-600">{{ Str::limit($resep->deskripsi, 50) }}</p>
                    <a href="{{ route('resep.show', $resep->id) }}" class="mt-2 inline-block bg-blue-500 text-white px-3 py-2 rounded-md">Lihat Detail</a>
                </div>
            </div>
            @empty
            <p>Tidak ada resep tersedia.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
