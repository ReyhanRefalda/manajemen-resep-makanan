<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Card 1: Image and Recipe Name -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <!-- Image -->
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $resep->image) }}" alt="{{ $resep->nama }}" class="w-full h-auto object-cover rounded-md">
                </div>
                <!-- Recipe Name -->
                <h1 class="text-xl font-bold mb-2">{{ $resep->nama }}</h1>
            </div>
        </div>

        <!-- Card 2: Creator, Description, and Category -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <p class="text-gray-700 mb-2"><strong>Pembuat:</strong> {{ $resep->pembuat->nama }}</p>
                <p class="text-gray-600 "><strong>Deskripsi:</strong> {{ $resep->deskripsi }}</p>
                <p class="text-gray-700"><strong>Kategori:</strong> {{ $resep->kategori->nama }}</p>
                <p class="text-gray-700"><strong>Waktu Persiapan:</strong> {{ $resep->waktu_persiapan }}</p>
                <p class="text-gray-700"><strong>Waktu Memasak:</strong> {{ $resep->waktu_memasak }}</p>
            </div>
        </div>

        <!-- Card 3: Ingredients -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Bahan-bahan</h3>
                <ul class="list-disc list-inside text-sm">
                    @forelse($resep->bahans as $bahan)
                        <li class="mb-1">{{ $bahan->nama }} : {{ $bahan->pivot->jumlah }}</li>
                    @empty
                        <li>Tidak ada bahan.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Card 4: Steps -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Langkah-langkah</h3>
                <ul class="list-disc list-inside text-sm">
                    @forelse($resep->langkahs as $langkah)
                        <li class="mb-1"><strong>Langkah {{ $langkah->nomor }}:</strong> {{ $langkah->deskripsi }}</li>
                    @empty
                        <li>Tidak ada langkah.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <a href="{{ route('resep.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition duration-300">
            Kembali ke Daftar Resep
        </a>
    </div>
</x-app-layout>
