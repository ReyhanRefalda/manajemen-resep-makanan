<x-app-layout>
    <div class="container mx-auto">
        <x-slot name="header">
            <h2 class="font-semibold text-center text-xl text-gray-800 leading-tight">
                {{ __('Resep Nusantara') }}
            </h2>
        </x-slot>
        
        <div class="flex justify-center m-6">
            <form action="{{ route('dashboard') }}" method="GET" class="relative w-full max-w-md">
                <input type="text" name="search" placeholder="Cari Resep atau Bahan..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" value="{{ request()->get('search') }}" />
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mt-6">
            @forelse($reseps as $resep)
            <div class="bg-white shadow-md rounded-lg overflow-hidden flex flex-col lg:flex-row">
                <!-- Content Side -->
                <div class="flex-1 p-4">
                    <h3 class="text-lg font-bold">{{ $resep->nama }}</h3>
                    <p class="text-gray-600">Pembuat: {{ $resep->pembuat->nama }}</p>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @forelse($resep->bahans->take(5) as $bahan)
                        <p class="bg-gray-100 px-2 py-1 rounded-md border border-gray-300">
                            {{ $bahan->nama }}
                        </p>
                        @empty
                        <p class="bg-gray-100 px-2 py-1 rounded-md border border-gray-300">
                            Tidak ada bahan.
                        </p>
                        @endforelse
                    </div>
                    <a href="{{ route('resep.show', $resep->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-3 py-2 rounded-md">Lihat Detail</a>
                </div>
        
                <!-- Image Side -->
                <div class="w-full lg:w-1/3">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}">
                </div>
            </div>
            @empty
            <div class="flex items-center justify-center w-full col-span-full mt-6">
                <p class="text-gray-600 text-lg">Tidak ada resep tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
