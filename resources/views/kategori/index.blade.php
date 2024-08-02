<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Kategori') }}
            </h2>
            
        </x-slot>
       
        <!-- Card untuk Tabel -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
            <div class="p-4">
                @if(session('success'))
                    <div id="success-alert" class="bg-green-500 text-white p-4 rounded mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            setTimeout(function () {
                                const alert = document.getElementById('success-alert');
                                if (alert) {
                                    alert.style.opacity = 0;
                                    setTimeout(function () {
                                        alert.style.display = 'none';
                                    }, 500); // 500ms to wait until the fade out is complete
                                }
                            }, 6000); // 3000ms = 3 seconds
                        });
                    </script>
                @endif
                <div class="flex items-center justify-between mb-4">
                    <!-- Search Form -->
                    <div class="relative flex-1 max-w-md">
                        <form action="{{ route('kategori.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori ..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" />
                            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                
                    <!-- Add Button -->
                    <a href="{{ route('kategori.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 ml-4">
                        Tambah Kategori
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center">No</th>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center">Nama</th>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($kategoris as $kategori)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                    <td class="px-4 py-2 text-sm text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-sm text-center">{{ $kategori->nama }}</td>
                                    <td class="px-4 py-2 text-sm text-center">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('kategori.edit', $kategori) }}" class="bg-yellow-500 text-white px-3 py-1 shadow hover:bg-yellow-600 transition duration-300 text-xs flex items-center">
                                                <i class="fa-solid fa-pen p-1"></i>
                                            </a>
                                            
                                            <!-- Delete Form -->
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 shadow hover:bg-red-600 transition duration-300 text-xs flex items-center" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    <i class="fa-solid fa-trash p-1"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @if(request('search'))
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-4">Tidak ada kategori yang ditemukan untuk pencarian "{{ request('search') }}"</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 py-4">Tidak ada data kategori</td>
                                    </tr>
                                @endif
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
