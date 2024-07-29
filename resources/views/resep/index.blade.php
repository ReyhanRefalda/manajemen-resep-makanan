<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Resep') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Page Heading -->
        

        <!-- Card with Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('resep.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 flex items-center">
                        <i class="bi bi-plus-circle mr-2"></i> Tambah Resep
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Gambar</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Waktu Persiapan</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Waktu Memasak</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-2 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($resep as $item)
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
                                    <td class="px-4 py-3 text-center text-sm">{{ $item->waktu_persiapan }}</td>
                                    <td class="px-4 py-3 text-center text-sm">{{ $item->waktu_memasak }}</td>
                                    <td class="px-4 py-3 text-center text-sm">{{ $item->kategori->nama }}</td>
                                    <td class="px-4 py-3 text-center text-sm">{{ Str::limit($item->deskripsi, 20) }}</td>
                                    <td class="px-4 py-3 text-center text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('resep.show', $item) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-600 transition duration-300 text-sm flex items-center">
                                                <i class="bi bi-eye mr-1"></i> Detail
                                            </a>
                                            <a href="{{ route('resep.edit', $item) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition duration-300 text-sm flex items-center">
                                                <i class="bi bi-pencil-square mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('resep.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition duration-300 text-sm flex items-center" onclick="return confirm('Yakin ingin menghapus resep ini?')">
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
