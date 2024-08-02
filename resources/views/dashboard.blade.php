<x-app-layout>
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <!-- Profile dropdown here -->
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
