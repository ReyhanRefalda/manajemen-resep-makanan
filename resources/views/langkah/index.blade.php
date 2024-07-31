<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Langkah') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-8 px-4">
        <!-- Daftar Langkah -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl mx-auto p-6">
            <div class="flex justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Langkah-langkah Resep</h3>
                <a href="{{ route('langkah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                    Tambah Langkah
                </a>
            </div>

            <!-- Menampilkan Pesan Sukses -->
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($langkah->isEmpty())
                <p class="text-gray-500">Belum ada langkah yang ditambahkan.</p>
            @else
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resep</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($langkah as $index => $step)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $step->resep->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($step->deskripsi, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('langkah.show', $step) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                    <a href="{{ route('langkah.edit', $step) }}" class="text-green-600 hover:text-green-900 ml-4">Edit</a>
                                    <form action="{{ route('langkah.destroy', $step) }}" method="POST" class="inline-block ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
