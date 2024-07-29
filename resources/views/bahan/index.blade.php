<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Bahan') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Button to Add New Bahan -->
        

        <!-- Table with Data -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto">
            <div class="p-4">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('bahan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 flex items-center">
                        <i class="bi bi-plus-circle mr-2"></i> Tambah Bahan
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($bahans as $bahan)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-300">
                                    <td class="px-4 py-3 text-center text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-center text-sm">{{ $bahan->nama }}</td>
                                    <td class="px-4 py-3 text-center text-sm">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('bahan.edit', $bahan->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition duration-300 text-xs flex items-center">
                                                <i class="bi bi-pencil-square mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('bahan.destroy', $bahan->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600 transition duration-300 text-xs flex items-center" onclick="return confirm('Yakin ingin menghapus bahan ini?')">
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
