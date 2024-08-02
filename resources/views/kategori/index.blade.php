<x-app-layout>
    <div class="container mx-auto mt-8 px-4">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Kategori') }}
            </h2>
        </x-slot>

        <!-- Alert untuk pesan sukses dan error -->
        @if (session('success'))
            <div id="success-alert" class="bg-green-500 text-white p-4 rounded mb-4">
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
                    }, 6000); // 6000ms = 6 seconds
                });
            </script>
        @endif

        @if (session('error'))
            <div id="error-alert" class="bg-red-500 text-white p-4 rounded mb-4">
                {{ session('error') }}
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    setTimeout(function () {
                        const alert = document.getElementById('error-alert');
                        if (alert) {
                            alert.style.opacity = 0;
                            setTimeout(function () {
                                alert.style.display = 'none';
                            }, 500); // 500ms to wait until the fade out is complete
                        }
                    }, 6000); // 6000ms = 6 seconds
                });
            </script>
        @endif

        <!-- Tabel Kategori -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="relative flex-1 max-w-md">
                        <form action="{{ route('kategori.index') }}" method="GET" class="flex">
                            <input type="text" name="search" placeholder="Cari Kategori..." class="pl-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 w-full" value="{{ request()->get('search') }}" />
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
                    @if($kategoris->isEmpty() && request()->get('search'))
                        <p class="text-center text-gray-500 py-4">Tidak ada kategori yang ditemukan untuk pencarian "{{ request('search') }}"</p>
                    @elseif($kategoris->isEmpty())
                        <p class="text-center text-gray-500 py-4">Tidak ada data kategori</p>
                    @else
                        <table class="w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-200 text-gray-600">
                                <tr>
                                    <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">No</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($kategoris as $kategori)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                        <td class="px-4 py-3 text-center text-sm">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center text-sm">{{ $kategori->nama }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <div class="flex justify-center space-x-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="bg-yellow-500 text-white px-3 py-1 shadow hover:bg-yellow-600 transition duration-300 text-sm flex items-center">
                                                    <i class="fa-solid fa-pen p-1"></i>
                                                </a>
                                                
                                                <!-- Delete Form -->
                                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 shadow hover:bg-red-600 transition duration-300 text-sm flex items-center" onclick="return confirm('Apakah anda yakin ingin menghapus data berikut?')">
                                                        <i class="fa-solid fa-trash p-1"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
