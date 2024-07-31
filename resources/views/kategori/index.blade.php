<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kategori') }}
        </h2>
    </x-slot>
    <div class="container mx-auto mt-8 px-4">
        <!-- Card untuk Tabel -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
            <div class="p-4">
                @if(session('success'))
                    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
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
                            }, 1000); // 3000ms = 3 seconds
                        });
                    </script>
                @endif
                <div class="flex justify-start mb-6">
                    <a href="{{ route('kategori.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 flex items-center">
                        <i class="bi bi-plus-circle mr-2"></i> Tambah Kategori
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center ">No</th>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center ">Nama</th>
                                <th class="px-4 py-3 text-xs font-medium uppercase tracking-wider text-center ">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($kategoris as $kategori)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                    <td class="px-4 py-2 text-sm text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-sm text-center">{{ $kategori->nama }}</td>
                                    <td class="px-4 py-2 text-sm text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('kategori.edit', $kategori) }}" class="bg-yellow-500 text-white px-3 py-1  shadow hover:bg-yellow-600 transition duration-300 text-xs flex items-center">
                                                <i class="bi bi-pencil-square mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('kategori.destroy', $kategori) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1  shadow hover:bg-red-600 transition duration-300 text-xs flex items-center" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    <i class="bi bi-trash mr-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
