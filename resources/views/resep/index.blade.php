<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Resep') }}
            </h2>
            
        </x-slot>

        <!-- Card with Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            @if(session('success'))
                <div id="success-alert" class="bg-green-500 text-white p-4 rounded mb-4" role="alert">
                    {{ session('success') }}
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            const alert = document.getElementById('success-alert');
                            if (alert) {
                                alert.style.opacity = 0;
                                setTimeout(function() {
                                    alert.style.display = 'none';
                                }, 500);
                            }
                        }, 6000);
                    });
                </script>
                @endif
            <div class="p-4">
                <div class="flex items-center justify-between mb-6">
                    <!-- Search Form -->
                    <div class="relative flex-1 max-w-md">
                        <form action="{{ route('resep.index') }}" method="GET" class="flex">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Cari resep..." 
                                class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" 
                                value="{{ request()->get('search') }}" 
                            />
                            <button 
                                type="submit" 
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"
                            >
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Add Button -->
                    <a 
                        href="{{ route('resep.create') }}" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 flex items-center ml-4"
                    >
                        <i class="bi bi-plus-circle mr-2"></i> Tambah Resep
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Gambar</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Nama Resep</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Pembuat</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Waktu Persiapan</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Waktu Memasak</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Bahan</th> <!-- Kolom baru -->
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($reseps as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                <td class="px-4 py-3 text-center text-sm">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->nama }}" class="w-24 h-24 object-cover rounded-md shadow-sm mx-auto">
                                    @else
                                    Tidak ada gambar
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item->nama }}</td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item->pembuat->nama }}</td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item->waktu_persiapan }}</td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item->waktu_memasak }}</td>
                                <td class="px-4 py-3 text-center text-sm">{{ $item->kategori->nama }}</td>
                                <td class="px-4 py-3 text-center text-sm">{{ Str::limit($item->deskripsi, 20) }}</td>
                                <td class="px-4 py-3 text-center text-sm">
                                    {{ $item->bahans->pluck('nama')->implode(', ') }}
                                </td>


                                <td class="px-4 py-3 text-center text-sm">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('resep.show', $item) }}" class="bg-blue-500 text-white px-3 py-1 shadow hover:bg-blue-600 transition duration-300 text-sm flex items-center">
                                            <i class="fa-solid fa-eye p-1"></i>
                                        </a>
                                        <a href="{{ route('resep.edit', $item) }}" class="bg-yellow-500 text-white px-3 py-1 shadow hover:bg-yellow-600 transition duration-300 text-sm flex items-center">
                                            <i class="fa-solid fa-pen p-1"></i>
                                        </a>
                                        <form action="{{ route('resep.destroy', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 shadow hover:bg-red-600 transition duration-300 text-sm flex items-center" onclick="return confirm('Yakin ingin menghapus resep ini?')">
                                                <i class="fa-solid fa-trash p-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-gray-500 py-4">
                                    @if(request('search'))
                                    Tidak ada resep yang ditemukan untuk pencarian "{{ request('search') }}"
                                    @else
                                    Tidak ada resep yang tersedia.
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>